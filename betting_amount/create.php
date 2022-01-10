<?php

//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/constants.php";
include_once "../config/database.php";

$id = '';
$bettingRaceHorseId = '';
$bettingAmountType = '';
$amount = '';



$data = json_decode(file_get_contents("php://input"));

if(!property_exists($data, 'bettingRaceHorseId')|| $data->bettingRaceHorseId =='null' || $data->bettingRaceHorseId == '') {
    $data = ['message' => 'Invalid bettingRaceHorseId', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'bettingAmountType')|| $data->bettingAmountType =='null' || $data->bettingAmountType == '') {
    $data = ['message' => 'Invalid bettingAmountType', 'status' => "error"];
            echo json_encode($data);
            exit();
}
else if(!property_exists($data, 'amount')|| $data->amount =='null' || $data->amount == '') {
    $data = ['message' => 'Invalid amount', 'status' => "error"];
            echo json_encode($data);
            exit();
}

  
    $bettingRaceHorseId = $data->bettingRaceHorseId;
    $bettingAmountType = $data->bettingAmountType;
    $amount = $data->amount;


    if(isset($bettingRaceHorseId) && isset($bettingAmountType) && isset($amount)){
    $query = "INSERT INTO bettingamount (bettingRaceHorseId,bettingAmountType,amount) VALUES (:bettingRaceHorseId,:bettingAmountType,:amount)";
    
    $stmt = $conn->prepare($query);

    $stmt->execute(['bettingRaceHorseId' => $bettingRaceHorseId,'bettingAmountType' => $bettingAmountType, 'amount' => $amount]);

    $insertedid = $conn->lastInsertId();
    //$last_id = 1;
    $querySelect = "SELECT id,bettingRaceHorseId,bettingAmountType,amount FROM bettingamount WHERE  id = :id ";

//prepare the query statement
$stmtSelect = $conn->prepare($querySelect);

//execute the query
$stmtSelect->execute(['id' => $insertedid]);

$bettingcen =  $stmtSelect->fetch(PDO::FETCH_ASSOC);


    echo json_encode($bettingcen);

}else{
    echo json_encode(array("message"=>"Betting Center was not created"));
}