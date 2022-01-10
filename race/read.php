<?php
//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$id = '';
$name = '';
$identifier = '';
$date = '';
$description = '';
$extendedJson = '';
$createdBy	 = '';
$createdDate = '';
$isDeleted = '';

//include database
include_once "../config/constants.php";
include_once "../config/database.php";

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
    
    //set response code - 200 OK
    //http_response_code(200);
    //Turn to JSON and output (show  data in JSON format)
    echo json_encode($race_arr);
    
    }else{

    $race_arr["Success"] = false; 
    echo json_encode($race_arr);    
    //set response code - 404 Not found
    //http_response_code(404);
  
    //echo json_encode(array("message"=>"No Race Found")
  
    
    }

    ?>