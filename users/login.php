<?php

//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/constants.php";
include_once "../config/database.php";

$userName = '';
$password = '';

$userName = isset($_GET["userName"]) ? $_GET["userName"] : die();

$password = isset($_GET["password"]) ? $_GET["password"] : die();

$loginQuery = "SELECT * FROM user WHERE userName = :userName AND password = :password";

$stmt = $conn->prepare($loginQuery);

$stmt->execute(['userName' => $userName,'password' => $password,]);

if($stmt->rowCount() > 0){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(array("message"=>"Login Successful"));
    echo json_encode($row);
}else{
    echo json_encode(array("message"=>"Login Failed"));

}