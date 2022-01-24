<?php
//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database
include_once "../config/constants.php";
include_once "../config/database.php";

$id = '';
$name = '';
$identifier = '';
$date = '';
$description = '';
$extendedJson = '';
$createdBy	 = '';
$createdDate = '';
$isDeleted = '';

//create query
$query = "SELECT id, name, identifier, date, description,extendedJson, createdBy, createdDate, isDeleted FROM race ORDER BY id DESC";

//prepare the query statement
$stmt = $conn->prepare($query);

//execute the query
$stmt->execute();
$num = $stmt->rowCount();

//check if more than zero race found
if($num > 0){
    // array
    $race_arr = array();
    $race_arr["data"] = array(); 
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
         extract($row);
    
         $race_record = array(
             "id" => $id,
             "name" =>$name,
             "identifier" =>$identifier,
             "date" => $date,
             "description" =>$description,
             "extendedJson" =>$extendedJson,
             "createdBy" =>$createdBy,
             "createdDate" =>$createdDate,
             "isDeleted" =>$isDeleted
         );
    
         //push to data
         array_push($race_arr["data"], $race_record);
         $race_arr["Success"] = true; 
    }
    
    //Turn to JSON and output (show  data in JSON format)
    echo json_encode($race_arr);
    
    }else{

    $race_arr["Success"] = false; 
    echo json_encode($race_arr);    
    }
    ?>