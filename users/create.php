<?php

//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/constants.php";
include_once "../config/database.php";

$firstName = '';
$lastName = '';
$userName = '';
$password = '';

$data = json_decode(file_get_contents("php://input"));

if(!property_exists($data, 'firstName') || $data->firstName =='null' || $data->firstName == '') {
    $data = ['message' => 'Invalid fistName', 'status' => "error"];
            echo json_encode($data);
            exit();
}
  
    $firstName = $data->firstName;
    $lastName = $data->lastName;
    $userName = $data->userName;
    $password = $data->password;

    if(isset($firstName) && isset($lastName) && isset($userName) && isset($password)){
    $query = "INSERT INTO user (firstName, lastName, userName, password, isActive) VALUES (:firstName,:lastName,:userName,:password,1)";
    
    $stmt = $conn->prepare($query);

    $stmt->execute(['firstName' => $firstName,'lastName' => $lastName,'userName' => $userName,'password' => $password]);

    $last_id = $stmt.lastrowid;
    
    //$last_id = 1;
    $querySelect = "SELECT id,firstName,lastName,userName FROM user WHERE  id = :id ";

//prepare the query statement
$stmtSelect = $conn->prepare($querySelect);

//execute the query
$stmtSelect->execute(['id' => $last_id ]);

$user =  $stmtSelect->fetch(PDO::FETCH_ASSOC);

    echo json_encode($user);

}else{
    echo json_encode(array("message"=>"User was not created"));
}