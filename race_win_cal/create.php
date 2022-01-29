<?php

//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/constants.php";
include_once "../config/database.php";

$id = '';
$bittingDate = '';
$executingDateTime = '';
$startTime = '';
$endTime = '';
$createdBy = '';

$data = json_decode(file_get_contents("php://input"));

if(!property_exists($data, 'bittingDate')|| $data->bittingDate =='null' || $data->bittingDate == '') {
    $data = ['message' => 'Invalid bittingDate', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'startTime')|| $data->startTime =='null' || $data->startTime == '') {
    $data = ['message' => 'Invalid startTime', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'endTime')|| $data->endTime =='null' || $data->endTime == '') {
    $data = ['message' => 'Invalid endTime', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'createdBy')|| $data->createdBy =='null' || $data->createdBy == '') {
    $data = ['message' => 'Invalid createdBy', 'status' => "error"];
            echo json_encode($data);
            exit();
}
  
    $bittingDate = $data->bittingDate;
    $executingDateTime = date('Y-m-d H:i:s');
    $startTime = $data->startTime;
    $endTime = $data->endTime;
    $createdBy = $data->createdBy;

    if(isset($bittingDate) && isset($executingDateTime) && isset($startTime) && isset($endTime) && isset($createdBy)){
    $query = "INSERT INTO racewinningcalculation (bittingDate, executingDateTime,startTime,endTime,createdBy) VALUES (:bittingDate,:executingDateTime,:startTime,:endTime,:createdBy)";  
    $stmt = $conn->prepare($query);
    $stmt->execute(['bittingDate' => $bittingDate,'executingDateTime' => $executingDateTime,'startTime' => $startTime,'endTime' => $endTime,'createdBy' => $createdBy]);

    $insertedid = $conn->lastInsertId();

    //$last_id = 1;
    $querySelect = "SELECT id,bittingDate,executingDateTime,startTime,endTime,createdBy FROM racewinningcalculation WHERE  id = :id ";

//prepare the query statement
$stmtSelect = $conn->prepare($querySelect);

//execute the query
$stmtSelect->execute(['id' => $insertedid]);

$bettingcen =  $stmtSelect->fetch(PDO::FETCH_ASSOC);
  echo json_encode($bettingcen);
}
else{    
    echo json_encode(array("message"=>"Race Winning Calculation  was not created"));
}

