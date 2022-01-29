<?php

//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/constants.php";
include_once "../config/database.php";

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
    $query = "INSERT INTO bettingclosing (bettingDate,closingTime,CreatedBy,createdDate) VALUES (:bettingDate,:closingTime,:CreatedBy,:createdDate)";
    $stmt = $conn->prepare($query);
    $stmt->execute(['bettingDate' => $bettingDate,'closingTime' => $closingTime, 'CreatedBy' => $CreatedBy,'createdDate' => $createdDate]);

    $insertedid = $conn->lastInsertId();
    $querySelect = "SELECT id,bettingDate,closingTime,CreatedBy,createdDate FROM bettingclosing WHERE  id = :id ";

//prepare the query statement
$stmtSelect = $conn->prepare($querySelect);

//execute the query
$stmtSelect->execute(['id' => $insertedid]);

$bettingcen =  $stmtSelect->fetch(PDO::FETCH_ASSOC);

    echo json_encode($bettingcen);
}else{
    echo json_encode(array("message"=>"Betting Center was not created"));
}