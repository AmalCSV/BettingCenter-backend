<?php

//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/constants.php";
include_once "../config/database.php";

$id = '';
$name = '';
$identifier = '';
$date = '';
$description = '';
$extendedJson = '';
$createdBy	 = '';
$createdDate = '';
$isDeleted = '';

$data = json_decode(file_get_contents("php://input"));

if(!property_exists($data, 'name')|| $data->name =='null' || $data->name == '') {
    $data = ['message' => 'Invalid name', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'identifier')|| $data->identifier =='null' || $data->identifier == '') {
    $data = ['message' => 'Invalid identifier', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'date')|| $data->date =='null' || $data->date == '') {
    $data = ['message' => 'Invalid date', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'description')|| $data->description =='null' || $data->description == '') {
    $data = ['message' => 'Invalid description', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'extendedJson')|| $data->extendedJson =='null' || $data->extendedJson == '') {
    $data = ['message' => 'Invalid extendedJson', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'createdBy')|| $data->createdBy =='null' || $data->createdBy == '') {
    $data = ['message' => 'Invalid createdBy', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'isDeleted')|| $data->isDeleted =='null' || $data->isDeleted == '') {
    $data = ['message' => 'Invalid isDeleted', 'status' => "error"];
            echo json_encode($data);
            exit();
}
    $name = $data->name;
    $identifier = $data->identifier;
    $date = $data->date;
    $description = $data->description;
    $extendedJson = $data->extendedJson;
    $createdBy = $data->createdBy;
    $createdDate = date('Y-m-d H:i:s');
    $isDeleted = $data->isDeleted;

    if(isset($name) && isset($identifier) && isset($date) && isset($description) && isset($extendedJson) && isset($createdBy) && isset($createdDate) && isset($isDeleted)){
    $query = "INSERT INTO race (name, identifier, date, description,extendedJson, createdBy, createdDate, isDeleted) VALUES (:name,:identifier,:date,:description,:extendedJson,:createdBy,:createdDate,:isDeleted)";
    
    $stmt = $conn->prepare($query);

    $stmt->execute(['name' => $name,'identifier' => $identifier,'date' => $date,'description' => $description,'extendedJson' => $extendedJson,'createdBy' => $createdBy,'createdDate' => $createdDate,'isDeleted' => $isDeleted]);

    $insertedid = $conn->lastInsertId();
    //$last_id = 1;
    $querySelect = "SELECT id,name,identifier,date,description,extendedJson,createdBy,createdDate,isDeleted FROM race WHERE  id = :id ";

//prepare the query statement
$stmtSelect = $conn->prepare($querySelect);

//execute the query
$stmtSelect->execute(['id' => $insertedid]);

$race =  $stmtSelect->fetch(PDO::FETCH_ASSOC);

    echo json_encode($race);
}
else{
    echo json_encode(array("message"=>"Race was not created"));
}