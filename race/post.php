<?php

//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/constants.php";
include_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"));

//racewinning table
$raceId = $data->raceId;
$raceIdentifier = $data->raceIdentifier;
$raceDateTime = date('Y-m-d H:i:s');
$createdBy = $data->createdBy;
$createdDate = date('Y-m-d H:i:s');

//racewinninghorse table

$raceWinningId = $data->raceWinningId;
$horseCode = $data->horseCode;
$winingPlace = $data->winingPlace;
$amountFront = $data->amountFront;
$amountBack = $data->amountBack;

if(isset($raceId) && isset($raceIdentifier) && isset($raceDateTime) && isset($createdBy) && isset($createdDate)){

    $queryRaceWinning = "INSERT INTO racewinning (raceId, raceIdentifier, raceDateTime, createdBy, createdDate) VALUES (:raceId,:raceIdentifier,:raceDateTime,:createdBy,:createdDate)";
    
    $stmtRaceWinning = $conn->prepare($queryRaceWinning);

    $stmtRaceWinning ->execute(['raceId' => $raceId,'raceIdentifier' => $raceIdentifier,'raceDateTime' => $raceDateTime,'createdBy' => $createdBy,'createdDate' => $createdDate]);

    echo json_encode(array("message"=>"Data Passed to 1st table"));

    $insertedId = $conn->lastInsertId();

    $queryRaceWinningHorse = "INSERT INTO racewinninghorse (id, raceId, raceWinningId, horseCode, winingPlace, amountFront, amountBack, isNotRun) VALUES (:id,$raceId,:raceWinningId,:horseCode,:winingPlace,:amountFront,:amountBack,0)";

    $stmtRaceWinningHorse = $conn->prepare($queryRaceWinningHorse);

    $stmtRaceWinningHorse ->execute(['id' => $insertedId,'raceWinningId' => $raceWinningId,'horseCode' => $horseCode,'winingPlace' => $winingPlace,'amountFront' => $amountFront,'amountBack' => $amountBack]);

    echo json_encode(array("message"=>"Data Passed to 2nd table"));

}else{
    echo json_encode(array("message"=>"Data Not Passed"));
}