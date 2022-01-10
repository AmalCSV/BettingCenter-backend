<?php

//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/constants.php";
include_once "../config/database.php";

$id = '';
$customer = '';
$bettingDate = '';
$bettingCenterId = '';
$bettingAmount = '';
$winningAmount = '';
$createdBy	 = '';
$createdDate = '';



$data = json_decode(file_get_contents("php://input"));

if(!property_exists($data, 'customer')|| $data->customer =='null' || $data->customer == '') {
    $data = ['message' => 'Invalid customer', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'bettingDate')|| $data->bettingDate =='null' || $data->bettingDate == '') {
    $data = ['message' => 'Invalid bettingDate', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'bettingCenterId')|| $data->bettingCenterId =='null' || $data->bettingCenterId == '') {
    $data = ['message' => 'Invalid bettingCenterId', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'bettingAmount')|| $data->bettingAmount =='null' || $data->bettingAmount == '') {
    $data = ['message' => 'Invalid bettingAmount', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'winningAmount')|| $data->winningAmount =='null' || $data->winningAmount == '') {
    $data = ['message' => 'Invalid winningAmount', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'createdDate')|| $data->createdDate =='null' || $data->createdDate == '') {
    $data = ['message' => 'Invalid createdDate', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'createdBy')|| $data->createdBy =='null' || $data->createdBy == '') {
    $data = ['message' => 'Invalid createdBy', 'status' => "error"];
            echo json_encode($data);
            exit();
}


  
    $customer = $data->customer;
    $bettingDate = $data->bettingDate;
    $bettingCenterId = $data->bettingCenterId;
    $bettingAmount = $data->bettingAmount;
    $winningAmount = $data->winningAmount;
    $createdDate = $data->createdDate;
    $createdBy = $data->createdBy;
  


    if(isset($customer) && isset($bettingDate) && isset($bettingCenterId) && isset($bettingAmount) && isset($winningAmount)&& isset($createdDate) && isset($createdBy) ){
    $query = "INSERT INTO betting (customer, bettingDate, bettingCenterId, bettingAmount,winningAmount,createdDate,createdBy) VALUES (:customer,:bettingDate,:bettingCenterId,:bettingAmount,:winningAmount,:createdDate,:createdBy)";
    
    $stmt = $conn->prepare($query);

    $stmt->execute(['customer' => $customer,'bettingDate' => $bettingDate,'bettingCenterId' => $bettingCenterId,'bettingAmount' => $bettingAmount,'winningAmount' => $winningAmount,'createdDate' => $createdDate,'createdBy' => $createdBy]);

    $insertedid = $conn->lastInsertId();
    //$last_id = 1;
    $querySelect = "SELECT id,customer,bettingDate,bettingCenterId,bettingAmount,winningAmount,createdDate,createdBy FROM betting WHERE  id = :id ";

//prepare the query statement
$stmtSelect = $conn->prepare($querySelect);

//execute the query
$stmtSelect->execute(['id' => $insertedid]);

$race =  $stmtSelect->fetch(PDO::FETCH_ASSOC);


    echo json_encode($race);

}else{
    echo json_encode(array("message"=>"Betting Center was not created"));
}