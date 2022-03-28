<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

try{
$id = '';
$bettingDate = '';
$closingTime = '';
$CreatedBy = '';
$createdDate = '';

$data = json_decode(file_get_contents("php://input"));

if(!property_exists($data, 'bettingDate')|| $data->bettingDate =='null' || $data->bettingDate == '') {
    $data = ['message' => 'Invalid bettingDate', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'closingTime')|| $data->closingTime =='null' || $data->closingTime == '') {
    $data = ['message' => 'Invalid closingTime', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'CreatedBy')|| $data->CreatedBy =='null' || $data->CreatedBy == '') {
    $data = ['message' => 'Invalid CreatedBy', 'status' => "error"];
            echo json_encode($data);
            exit();
}
    $bettingDate = $data->bettingDate;
    $closingTime = $data->closingTime;
    $CreatedBy = $data->CreatedBy;
    $createdDate = date('Y-m-d H:i:s');

    if(isset($bettingDate) && isset($closingTime) && isset($CreatedBy) && isset($createdDate)){
    $query = "INSERT INTO bettingClosing (bettingDate,closingTime,CreatedBy,createdDate) VALUES (:bettingDate,:closingTime,:CreatedBy,:createdDate)";
    $stmt = $conn->prepare($query);
    $stmt->execute(['bettingDate' => $bettingDate,'closingTime' => $closingTime, 'CreatedBy' => $CreatedBy,'createdDate' => $createdDate]);

    $insertedid = $conn->lastInsertId();

    $querySelect = "SELECT id,bettingDate,closingTime,CreatedBy,createdDate FROM bettingClosing WHERE  id = :id ";
    $stmtSelect = $conn->prepare($querySelect);
    $stmtSelect->execute(['id' => $insertedid]);

    $bettingClosing =  $stmtSelect->fetch(PDO::FETCH_ASSOC);

    echo json_encode(array('success'=> true, 'data'=>$bettingClosing));

}else{
    echo json_encode(array("success" => false, "message"=>"Betting Center was not created"));
}
}catch(exception $e){
    echo json_encode(array("success"=>false,"message"=>$e));
}
?>