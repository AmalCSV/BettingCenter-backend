<?php
//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$id = '';
$name = '';
$address = '';
$contactPerson = '';
$phone = '';
$isActive = '';

//include database
include_once "../config/constants.php";
include_once "../config/database.php";

//create query
$query = "SELECT id, name, address,contactPerson, phone, isActive  FROM bettingcenter ORDER BY id DESC";

//prepare the query statement
$stmt = $conn->prepare($query);

//execute the query
$stmt->execute();

$num = $stmt->rowCount();

//check if more than zero found
if($num > 0){
    //bettingcen_record array
    $bettingcen_arr = array();
    $bettingcen_arr["data"] = array(); 
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
         extract($row);
    
         $bettingcen_record = array(
             "id" => $id,
             "name" =>$name,
             "address" =>$address,
             "contactPerson" =>$contactPerson,
             "phone" =>$phone,
             "isActive" =>$isActive
         );
    
         //push to data
         array_push($bettingcen_arr["data"], $bettingcen_record);
         $bettingcen_arr["Success"] = true; 
    }
    
    //set response code - 200 OK
    //http_response_code(200);
    //Turn to JSON and output 
    echo json_encode($bettingcen_arr);
    
    }else{

    $bettingcen_arr["Success"] = false; 
    echo json_encode($bettingcen_arr);  
    //set response code - 404 Not found
    //http_response_code(404);

    //echo json_encode(array("message"=>"No Betting Center Found")
    //);
    
    }


    ?>