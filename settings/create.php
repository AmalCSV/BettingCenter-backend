<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

$ide = '';
$companyName = '';
$address = '';
$tax = '';
$extendedJson = '';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$companyName = $data->companyName;
$address = $data->address;
$tax = $data->tax;
$extendedJson = $data->extendedJson;

if(isset($id) && isset($companyName) && isset($address) && isset($tax) && isset($extendedJson)){

$queryExist = " SELECT * FROM settings WHERE id = :id ";
    $stmtExist = $conn->prepare($queryExist);
    $stmtExist->execute(['id' => $id]);

        if( $stmtExist->rowCount() >0 ){
            $queryUpdate = "UPDATE settings SET companyName = :companyName, address = :address, tax = :tax, extendedJson = :extendedJson WHERE id = :id";
            $stmtUpdate = $conn->prepare($queryUpdate);

            //sanitize data(clean up for security)
            $id = htmlspecialchars(strip_tags($id));
            $companyName = htmlspecialchars(strip_tags($companyName));
            $address = htmlspecialchars(strip_tags($address));
            $tax = htmlspecialchars(strip_tags($tax));
            $extendedJson = htmlspecialchars(strip_tags($extendedJson));
      
            
            $stmtUpdate->execute(['id' =>$id, 'companyName' =>$companyName, 'address' =>$address, 'tax' =>$tax, 'extendedJson' =>$extendedJson ]);

            echo json_encode(array("message" => "Settings was updated"));

        }else{
            $queryInsert = "INSERT INTO settings (id,companyName,address,tax,extendedJson) VALUES (:id,:companyName,:address,:tax,:extendedJson)";
            $stmtInsert = $conn->prepare($queryInsert);

            //sanitize data(clean up for security)
            $id = htmlspecialchars(strip_tags($id));
            $companyName = htmlspecialchars(strip_tags($companyName));
            $address = htmlspecialchars(strip_tags($address));
            $tax = htmlspecialchars(strip_tags($tax));
            $extendedJson = htmlspecialchars(strip_tags($extendedJson));
         
            $stmtInsert->execute(['id' =>$id, 'companyName' =>$companyName, 'address' =>$address, 'tax' =>$tax, 'extendedJson' =>$extendedJson]);

            echo json_encode(array("message" => "Settings was created"));

        }
    }

    

        
    
    