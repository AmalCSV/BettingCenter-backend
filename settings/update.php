<?php
//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database
include_once "../config/constants.php";
include_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"));
    
    $id = $data->id;  
    $companyName = $data->companyName;
    $address = $data->address;
    $tax = $data->tax;
    $extendedJson = $data->extendedJson;
    
    if(isset($id) && isset($companyName) && isset($address) && isset($tax) && isset($extendedJson)){

    $updateQuery = "UPDATE settings SET companyName = :companyName, address = :address, tax = :tax, extendedJson = :extendedJson WHERE id = :id";

    $stmt = $conn->prepare($updateQuery);

    $id = htmlspecialchars(strip_tags($id));
    $companyName = htmlspecialchars(strip_tags($companyName));
    $address = htmlspecialchars(strip_tags($address)); 
    $tax = htmlspecialchars(strip_tags($tax));
    $extendedJson = htmlspecialchars(strip_tags($extendedJson));

    $stmt->execute(['id' => $id,'companyName' => $companyName,'address' => $address,'tax' => $tax,'extendedJson' => $extendedJson]);

    echo json_encode(array("message" => "Settings was updated."));
    }
    else{
        echo json_encode(array("message" => "Settings was not updated."));
    }
