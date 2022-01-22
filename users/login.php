<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"));

$userName = '';
$password = '';

if(!property_exists($data, 'userName') || $data->userName =='null' || $data->userName == '') {
    $output = ['message' => 'Invalid userName', 'success'=> false];
    echo json_encode($output);
    exit();
}

if(!property_exists($data, 'password') || $data->password =='null' || $data->password == '') {
    $output = ['message' => 'Invalid password', 'success'=> false];
            echo json_encode($output);
            exit();
}
$userName = $data->userName;
$password = md5($data->password);

$loginQuery = "SELECT id, userName, firstName,lastName FROM user WHERE userName = :userName AND password = :password";

$stmt = $conn->prepare($loginQuery);
$stmt->execute(['userName' => $userName,'password' => $password]);

if($stmt->rowCount() > 0){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(array('success'=> true, 'data'=>$row));
}else{
    echo json_encode(array('success'=> false,'message' =>"Login Failed"));

}