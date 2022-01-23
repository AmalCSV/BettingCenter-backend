<?php
//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database
include_once "../config/constants.php";
include_once "../config/database.php";

//create query
$queryRead = " SELECT id,firstName, lastName, userName FROM user WHERE isActive = 1 ORDER BY id DESC ";

//prepare the query statement
$stmt = $conn->prepare($queryRead);

//execute the query
$stmt->execute();

$num = $stmt->rowCount();

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
         );
         //push to data
         array_push($users_arr["data"], $user_record);

    }
    $users_arr["success"] = true; 
    //Turn to JSON and output (show users data in JSON format)
    echo json_encode($users_arr);
    ?>