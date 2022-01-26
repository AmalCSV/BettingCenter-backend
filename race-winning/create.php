<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"));

//racewinning table

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
    "winningHorse" : [{"horseCode" : "DEC", "winningPlace" : 1, "amount":100 }, {"horseCode" : "FINE","winningPlace" : 2, "amount":20 }],
}
*/
$winningHorse = $data->winningHorse;

if(isset($raceId) && isset($raceCode) && isset($raceDateTime) && isset($createdBy) && isset($createdDate)){

    $queryRaceWinning = "INSERT INTO racewinning (raceId,raceCode,raceDateTime,createdBy,createdDate) VALUES (:raceId , :raceCode, :raceDateTime, :createdBy, :createdDate) " ;
    $stmtRaceWinning = $conn->prepare($queryRaceWinning);
    $stmtRaceWinning ->execute(['raceId'=>$raceId, 'raceCode'=>$raceCode, 'raceDateTime'=>$raceDateTime, 'createdBy'=>$createdBy, 'createdDate'=>$createdDate ]);
    $insertedRaceWinningId = $conn->lastInsertId();

    foreach($winningHorse as $winningHorses){
        $queryRaceWinningHorse = "INSERT INTO racewinninghorse (raceWinningId, raceId, horseCode, winningPlace,amount) VALUES (:raceWinningId,:raceId,:horseCode,:winningPlace,:amount) ";
        $stmtRaceWinningHorse = $conn->prepare($queryRaceWinningHorse);
        $stmtRaceWinningHorse->execute(['raceWinningId'=>$insertedRaceWinningId, 'raceId'=>$raceId, 'horseCode'=>$winningHorses->horseCode, 'winningPlace'=>$winningHorses->winningPlace, 'amount'=>$winningHorses->amount ]);
    }

    echo json_encode(array("success" => true, "data" => array()));

}else{ 
    echo json_encode(array("success" => false, "message" => "Data Not Passed"));
} 