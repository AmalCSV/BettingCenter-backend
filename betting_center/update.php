<?php
//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database
include_once "../config/constants.php";
include_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"));

    $id = $data->id;    
    $name = $data->name;
    $address = $data->address;
    $contactPerson = $data->contactPerson;
    $phone = $data->phone;
    

    if(isset($id) && isset($name) && isset($address) && isset($contactPerson) && isset($phone)){

    $updateQuery = "UPDATE bettingcenter SET name = :name, address = :address,contactPerson = :contactPerson, phone = :phone WHERE id = :id";

    $stmt = $conn->prepare($updateQuery);

    $id = htmlspecialchars(strip_tags($id));
    $name = htmlspecialchars(strip_tags($name));
    $address = htmlspecialchars(strip_tags($address));
    $contactPerson = htmlspecialchars(strip_tags($contactPerson));
    $phone = htmlspecialchars(strip_tags($phone));

    $stmt->execute(['id' => $id,'name' => $name,'address' => $address,'contactPerson' => $contactPerson,'phone' => $phone]);

    echo json_encode(array("message" => "Betting Center was updated."));
    }

    else{
        echo json_encode(array("message" => "Betting Center was not updated."));
    }


