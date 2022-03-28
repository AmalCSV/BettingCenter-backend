<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

try{
$id = '';
$name = '';
$address = '';
$contactPerson = '';
$phone = '';
$isActive = '';

$data = json_decode(file_get_contents("php://input"));

if(!property_exists($data, 'name')|| $data->name =='null' || $data->name == '') {
    $data = ['message' => 'Invalid name', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'address')|| $data->address =='null' || $data->address == '') {
    $data = ['message' => 'Invalid address', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'contactPerson')|| $data->contactPerson =='null' || $data->contactPerson == '') {
    $data = ['message' => 'Invalid contactPerson', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'phone')|| $data->phone =='null' || $data->phone == '') {
    $data = ['message' => 'Invalid phone', 'status' => "error"];
            echo json_encode($data);
            exit();
}
  
    $name = $data->name;
    $address = $data->address;
    $contactPerson = $data->contactPerson;
    $phone = $data->phone;

    if(isset($name) && isset($address) && isset($contactPerson) && isset($phone)){
    $query = "INSERT INTO bettingCenter (name, address,contactPerson,phone,isActive) VALUES (:name,:address,:contactPerson,:phone,1)";
    $stmt = $conn->prepare($query);
    $stmt->execute(['name' => $name,'address' => $address,'contactPerson' => $contactPerson,'phone' => $phone]);

    $insertedid = $conn->lastInsertId();

    $querySelect = "SELECT id,name,address,contactPerson,phone,isActive FROM bettingcenter WHERE  id = :id ";
    $stmtSelect = $conn->prepare($querySelect);
    $stmtSelect->execute(['id' => $insertedid]);

$bettingcen =  $stmtSelect->fetch(PDO::FETCH_ASSOC);

    echo json_encode(array('success'=> true, 'data'=>$bettingcen));
}
else{
    echo json_encode(array("success"=>false,"message"=>"Betting Center was not created"));
}
}catch(exception $e){
    echo json_encode(array("success"=>false,"message"=>$e));
}

