<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"));

//racewinning table
try{
$raceId = $data->raceId;
$raceCode = $data->raceCode;
$raceDateTime = date('Y-m-d H:i:s');
$createdBy = $data->createdBy;
$createdDate = date('Y-m-d H:i:s');

/*
{
    "raceId" : 233,
    "raceCode" : 3432,
    "raceDateTime" : "2022-01-15 00:35:07",
    "createdBy" : "31",
    "wins": [
        {"winningHorse" : [{
            "horseCode" : "DEC", "winningPlace" : 1, "amountFront":100, "amountBack" : 30 
            }, 
            {
            "horseCode" : "FINE","winningPlace" : 2, "amountFront" : 20, "amountBack" : 10 
            }
        ],
        "amounts": [{"bettingHorseId":3,"amountTypeId":2,"amount": 100},
        {"bettingHorseId":4",amountTypeId":1,"amount": 20}]
        }
    ]
}
*/
$wins = $data->wins;

if(isset($raceId) && isset($raceCode) && isset($raceDateTime) && isset($createdBy) && isset($createdDate)){

    $queryRaceWinning = "INSERT INTO racewinning (raceId,raceCode,raceDateTime,createdBy,createdDate) VALUES (:raceId , :raceCode, :raceDateTime, :createdBy, :createdDate) " ;
    $stmtRaceWinning = $conn->prepare($queryRaceWinning);
    $stmtRaceWinning ->execute(['raceId'=>$raceId, 'raceCode'=>$raceCode, 'raceDateTime'=>$raceDateTime, 'createdBy'=>$createdBy, 'createdDate'=>$createdDate ]);
    $insertedRaceWinningId = $conn->lastInsertId();

    foreach($wins as $win){
    foreach($win->winningHorse as $winningHorses){
        $queryRaceWinningHorse = "INSERT INTO racewinninghorse (raceWinningId, raceId, horseCode, winningPlace,amountFront,amountBack) VALUES (:raceWinningId,:raceId,:horseCode,:winningPlace,:amountFront,:amountBack) ";
        $stmtRaceWinningHorse = $conn->prepare($queryRaceWinningHorse);
        $stmtRaceWinningHorse->execute(['raceWinningId'=>$insertedRaceWinningId, 'raceId'=>$raceId, 'horseCode'=>$winningHorses->horseCode, 'winningPlace'=>$winningHorses->winningPlace, 'amountFront'=>$winningHorses->amountFront, 'amountBack'=>$winningHorses->amountBack]);
    }
    foreach($win->amounts as $amount){
        $queryRaceWinningHorseAmount = "INSERT INTO racewinninghorseamount(bettingHorseId,amountTypeId,amount) VALUES (:bettingHorseId,:amountTypeId,:amount)";
        $stmtRaceWinningHorseAmount = $conn->prepare($queryRaceWinningHorseAmount);
        $stmtRaceWinningHorseAmount->execute(['bettingHorseId'=>$amount->bettingHorseId,'amountTypeId'=>$amount->amountTypeId,'amount'=>$amount->amount]);
    }
    }
    echo json_encode(array("success" => true, "data" => array()));

}else{ 
    echo json_encode(array("success" => false, "message" => "Data Not Passed"));
}
}catch(exception $e){
    echo json_encode(array("success"=>false,"message"=>$e));
} 