<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

try{
$id = '';
$companyName = '';
$address = '';
$tax = '';
$extendedJson = '';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
if ($data->id) {
    $id = $data->id;
 }

$companyName = $data->companyName;
$address = $data->address;
$tax = $data->tax;

$extendedJson = null;
 if ($data->extendedJson) {
    $extendedJson = $data->extendedJson;
 }

if(isset($companyName) && isset($address) && isset($tax)){
    $companyName = htmlspecialchars(strip_tags($companyName));
    $address = htmlspecialchars(strip_tags($address));
    $tax = htmlspecialchars(strip_tags($tax));
    $extendedJson = htmlspecialchars(strip_tags($extendedJson));

    if($id == null) {
        $queryInsert = "INSERT INTO settings (companyName,address,tax,extendedJson) VALUES (:companyName,:address,:tax,:extendedJson)";
        $stmtInsert = $conn->prepare($queryInsert);
        $stmtInsert->execute(['companyName' =>$companyName, 'address' =>$address, 'tax' =>$tax, 'extendedJson' =>$extendedJson]);
        echo json_encode(array("success" => true, "message" => "Settings was created"));
    } else {
        $queryExist = " SELECT * FROM settings WHERE id = :id ";
        $stmtExist = $conn->prepare($queryExist);
        $stmtExist->execute(['id' => $id]);
        
        if( $stmtExist->rowCount() > 0 ){
            $queryUpdate = "UPDATE settings SET companyName = :companyName, address = :address, tax = :tax, extendedJson = :extendedJson WHERE id = :id";
            $stmtUpdate = $conn->prepare($queryUpdate);
            $id = htmlspecialchars(strip_tags($id));
            $stmtUpdate->execute(['id' =>$id, 'companyName' =>$companyName, 'address' =>$address, 'tax' =>$tax, 'extendedJson' =>$extendedJson ]);
            echo json_encode(array("success" => true, "message" => "Settings was updated"));
        }else {
            echo json_encode(array( "success" => false, "message" => "No record for Id"));
        }

    }
} else {
    echo json_encode(array( "success" => false, "message" => "No record for requried fields"));
}

}catch(exception $e){
    echo json_encode(array("success" => false, "message" => $e));
}
?>