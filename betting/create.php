<?php

//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/constants.php";
include_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"));

//betting table
$customer = $data->customer;
$bettingDate = $data->bettingDate;
$bettingCenterId = $data->bettingCenterId;
$bettingAmount = $data->bettingAmount;
$winningAmount = $data->winningAmount;
$createdDate = date('Y-m-d H:i:s');
$createdBy = $data->createdBy;

//bettingamount table
$bettingRaceHorseId = $data->bettingRaceHorseId;
$bettingAmountType = $data->bettingAmountType;
$amount = $data->amount;

//bettinghorse table
$bettingId = $data->bettingId;
$raceCode = $data->raceCode;
$horseCode = $data->horseCode;



if(isset($customer) && isset($bettingDate) && isset($bettingCenterId) && isset($bettingAmount) && isset($winningAmount) && isset($createdDate) && isset($createdBy)){

    $queryBetting = "INSERT INTO betting (customer, bettingDate, bettingCenterId, bettingAmount, winningAmount,createdDate,createdBy) VALUES (:customer,:bettingDate,:bettingCenterId,:bettingAmount,:winningAmount,:createdDate,:createdBy)";
    
    $stmtBetting = $conn->prepare($queryBetting);

    $stmtBetting ->execute(['customer' => $customer,'bettingDate' => $bettingDate,'bettingCenterId' => $bettingCenterId,'bettingAmount' => $bettingAmount,'winningAmount' => $winningAmount,'createdDate' => $createdDate,'createdBy' => $createdBy]);

    echo json_encode(array("message"=>"Data Passed to tables"));

    $insertedId = $conn->lastInsertId();

    $queryBettingAmount = "INSERT INTO bettingamount (id, bettingRaceHorseId, bettingAmountType, amount) VALUES (:id,:bettingRaceHorseId,:bettingAmountType,:amount)";

    $stmtBettingAmount = $conn->prepare($queryBettingAmount);

    $stmtBettingAmount ->execute(['id' => $insertedId,'bettingRaceHorseId' => $bettingRaceHorseId,'bettingAmountType' => $bettingAmountType,'amount' => $amount]);

    //betting horse
    $insertedId = $conn->lastInsertId();

    $queryBettingHorse = "INSERT INTO bettinghorse (id, bettingId, raceCode, horseCode) VALUES (:id,:bettingId,:raceCode,:horseCode)";

    $stmtBettingHorse = $conn->prepare($queryBettingHorse);

    $stmtBettingHorse ->execute(['id' => $insertedId,'bettingId' => $bettingId,'raceCode' => $raceCode,'horseCode' => $horseCode]);

}else{ 
    echo json_encode(array("message"=>"Data Not Passed"));
} 