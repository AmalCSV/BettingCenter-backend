<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

$id = '';
$bettingDate = '';
$closingTime = '';
$CreatedBy = '';
$createdDate = '';

//create query
$query = "SELECT id, bettingDate,closingTime,CreatedBy,createdDate FROM bettingClosing ORDER BY id DESC";

//prepare the query statement
$stmt = $conn->prepare($query);

//execute the query
$stmt->execute();

$num = $stmt->rowCount();

//check if more than zero  found
if($num > 0){
    // array
    $bettingcen_arr = array();
    $bettingcen_arr["data"] = array(); 
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){  
         extract($row);
    
         $bettingcen_record = array(
             "id" => $id,
             "bettingDate" =>$bettingDate,
             "closingTime" => $closingTime,
             "CreatedBy" =>$CreatedBy,
             "createdDate" => $createdDate,

         );
         //push to data
         array_push($bettingcen_arr["data"], $bettingcen_record);
         $bettingcen_arr["Success"] = true; 
    }
    
    echo json_encode($bettingcen_arr);
    
    }else{

    $bettingcen_arr["Success"] = false; 
    echo json_encode($bettingcen_arr);   
    }

?>