<?php
//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$id = '';
$firstName = '';
$lastName = '';
$userName = '';
$password = '';
$isActive = '';

//include database
include_once "../config/constants.php";
include_once "../config/database.php";

//create query
$query = "SELECT * FROM user ORDER BY id DESC";

//prepare the query statement
$stmt = $conn->prepare($query);

//execute the query
$stmt->execute();

$num = $stmt->rowCount();

//check if more than zero users found
if($num > 0){
    //user array
    $users_arr = array();
    $users_arr["data"] = array(); 
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
         extract($row);
    
         $user_record = array(
             "id" => $id,
             "firstName" =>$firstName,
             "lastName" =>$lastName,
             "userName" =>$userName,
             "password" =>$password,
             "isActive" =>$isActive
         );
    
         //push to data
         array_push($users_arr["data"], $user_record);
    }
    
    //set response code - 200 OK
    http_response_code(200);
    //Turn to JSON and output (show users data in JSON format)
    echo json_encode($users_arr);
    
    }else{
    //set response code - 404 Not found
    http_response_code(404);
    //tell the user no Users found
    echo json_encode(array("message"=>"No Users Found")
    );
    
    }
    ?>