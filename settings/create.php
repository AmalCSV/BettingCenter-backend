<?php

//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/constants.php";
include_once "../config/database.php";

$id = '';
$companyName = '';
$address = '';
$tax = '';
$extendedJson = '';

$data = json_decode(file_get_contents("php://input"));

if(!property_exists($data, 'companyName')|| $data->companyName =='null' || $data->companyName == '') {
    $data = ['message' => 'Invalid companyName', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'address')|| $data->address =='null' || $data->address == '') {
    $data = ['message' => 'Invalid address', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'tax')|| $data->tax =='null' || $data->tax == '') {
    $data = ['message' => 'Invalid tax', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'extendedJson')|| $data->extendedJson =='null' || $data->extendedJson == '') {
    $data = ['message' => 'Invalid extendedJson', 'status' => "error"];
            echo json_encode($data);
            exit();
}
  
    $companyName = $data->companyName;
    $address = $data->address;
    $tax = $data->tax;
    $extendedJson = $data->extendedJson;

    if(isset($companyName) && isset($address) && isset($tax) && isset($extendedJson)){
    $query = "INSERT INTO settings (companyName, address,tax,extendedJson) VALUES (:companyName,:address,:tax,:extendedJson)";  

    $stmt = $conn->prepare($query);

    $stmt->execute(['companyName' => $companyName,'address' => $address,'tax' => $tax,'extendedJson' => $extendedJson]);

    $insertedid = $conn->lastInsertId();

    $querySelect = "SELECT id,companyName,address,tax,extendedJson FROM settings WHERE  id = :id ";

//prepare the query statement
$stmtSelect = $conn->prepare($querySelect);

//execute the query
$stmtSelect->execute(['id' => $insertedid]);

$setting =  $stmtSelect->fetch(PDO::FETCH_ASSOC);

    echo json_encode($setting);
}
else{ 
    echo json_encode(array("message"=>"Setting Center was not created"));
}