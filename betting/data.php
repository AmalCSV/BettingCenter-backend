<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

if(isset($_GET['date'])){
    $date = $_GET['date'];
    $query = "SELECT raceCode, horseCode FROM bettingHorse where bettingId in (SELECT  id FROM `betting` WHERE `bettingDate`=:bettingDate)";

    $stmt = $conn->prepare($query);
    $stmt->execute(['bettingDate'=>$date]);

    $bettingRaceData = array();
    $bettingRaceData['data'] = array(); 
    $raceHorseData = array();
    $raceHorseData['horses'] = array();
    $raceHorseData['race'] = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
         extract($row);
         $raceHorseRecord = array(
            "horseCode" => $horseCode,
            "raceCode" => $raceCode,
        );
         $raceRecord = array(
             "raceCode" => $raceCode,
             "horses" => array(),
         );

         array_push($raceHorseData['horses'], $raceHorseRecord); 
         array_push($bettingRaceData['data'], $raceRecord); 
    }

    $bettingRaceData['data'] = array_unique($bettingRaceData['data']);
    $raceHorseData['horses'] = array_unique($raceHorseData['horses']);

    foreach ($bettingRaceData['data'] as &$race){
        foreach($raceHorseData['horses'] as $horse) {
            if ($horse['raceCode'] == $race['raceCode']) {
                $horseRecord = array(
                    "horseCode" => $horse['horseCode'],
                );
                array_push($race['horses'], $horseRecord);
            }
        }
      }
    $bettingRaceData["success"] = true;

    echo json_encode($bettingRaceData);
} else {
    echo json_encode(array(
        "message" => 'No date value',
        "success" => false,
    ));
}
?>
