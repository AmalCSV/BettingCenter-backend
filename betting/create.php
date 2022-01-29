<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"));

//betting table
$customer = $data->customer;
$bettingDate = $data->bettingDate;
$bettingCenterId = $data->bettingCenterId;
$bettingAmount = $data->bettingAmount;
$createdBy = $data->createdBy;

$createdDate = date('Y-m-d H:i:s');


/*
bets : [{ bettingHorse: [{ raceCode:'w1', horseCode: 'wewe' ..], "amounts": [{"amountTypeId":2, 
            "amount": 100},
            {"amountTypeId":1, 
            "amount": 20}]}, 
 { raceCode:'w1', horseCode: 'wewe' ..], "amounts": [{"amountTypeId":2, 
            "amount": 100},
            {"amountTypeId":1, 
            "amount": 20}],]
 */

$bets = $data->bets;


if(isset($customer) && isset($bettingDate) && isset($bettingCenterId) && isset($bettingAmount) && isset($createdDate) && isset($createdBy) && isset($bets)){
    $calculatedBettingAmount = 0;//battingCalcuation($bets);
    $queryBetting = "INSERT INTO betting (customer, bettingDate, bettingCenterId, bettingAmount,createdDate,createdBy,winningAmount, calculateBettingAmount) VALUES (:customer,:bettingDate,:bettingCenterId,:bettingAmount,:createdDate,:createdBy,0,:calculateBettingAmount)";
    $stmtBetting = $conn->prepare($queryBetting);
    $stmtBetting ->execute(['customer' => $customer,'bettingDate' => $bettingDate,'bettingCenterId' => $bettingCenterId,'bettingAmount' => $bettingAmount,'createdDate' => $createdDate,'createdBy' => $createdBy, 'calculateBettingAmount' => $calculatedBettingAmount ]);
    $insertedBettingId = $conn->lastInsertId();

    foreach ($bets as $bet) {
        $queryBettingCollection = "INSERT INTO horseCollection (bettingId) VALUES (:bettingId)";
        $stmtBettingCollection = $conn->prepare($queryBettingCollection);
        $stmtBettingCollection ->execute(['bettingId' => $insertedBettingId]);
        $insertedBettingCollectionId = $conn->lastInsertId();

        foreach ($bet->amounts as $amount) {
            $queryBettingAmount = "INSERT INTO bettingamount (HorseCollectionId, bettingAmountType, amount) VALUES (:horseCollectionId,:bettingAmountType,:amount)";
            $stmtBettingAmount = $conn->prepare($queryBettingAmount);
            $stmtBettingAmount -> execute(['horseCollectionId' => $insertedBettingCollectionId,'bettingAmountType' => $amount->amountTypeId,'amount' => $amount->amount]);
        }

        foreach ($bet->bettingHorse as $bettingHorse){
            $queryBettingHorse = "INSERT INTO bettinghorse (horseCollectionId, raceCode, horseCode,bettingId) VALUES (:horseCollectionId,:raceCode,:horseCode,:bettingId)";
            $stmtBettingHorse = $conn->prepare($queryBettingHorse);
            $stmtBettingHorse ->execute(['horseCollectionId' => $insertedBettingCollectionId,'raceCode' => $bettingHorse->raceCode,'horseCode' => $bettingHorse->horseCode, 'bettingId' => $insertedBettingId ]);
        }
    }
      
    echo json_encode(array("success" => true, "data" => array()));
}else{ 
    echo json_encode(array("success" => false, "message" => "Data Not Passed"));
} 
