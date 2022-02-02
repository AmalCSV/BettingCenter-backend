<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

try{
$firstName = '';
$lastName = '';
$userName = '';
$password = '';

$data = json_decode(file_get_contents("php://input"));

$field = null;
if(!property_exists($data, 'firstName') || $data->firstName =='null' || $data->firstName == '') {
    $field = ['message' => 'Invalid fistName', 'success'=> false];
} else if(!property_exists($data, 'lastName') || $data->lastName =='null' || $data->lastName == '') {
    $field = ['message' => 'Invalid lastName', 'success'=> false];
} else if(!property_exists($data, 'userName') || $data->userName =='null' || $data->userName == '') {
    $field = ['message' => 'Invalid userName', 'success'=> false];
} else if(!property_exists($data, 'password') || $data->firstName =='password' || $data->password == '') {
    $field = ['message' => 'Invalid password', 'success'=> false];
}

if($field != null) {
    $output = ['message' => 'Invalid field : '.$field, 'success'=> false];
    echo json_encode($output);
    exit();
}
    $firstName = $data->firstName;
    $lastName = $data->lastName;
    $userName = $data->userName;
    $password = $data->password;
    $hashedPassword = md5($password);

    $queryExist = " SELECT * FROM user WHERE userName = :userName ";
    $stmtExist = $conn->prepare($queryExist);
    $stmtExist->execute(['userName' => $userName]);

        if( $stmtExist->rowCount() >0 ){
            $data = ['message' => 'Username already Exists', 'success'=> false];
            echo json_encode($data);
        }

    elseif(isset($firstName) && isset($lastName) && isset($userName) && isset($password)){
    $query = "INSERT INTO user (firstName, lastName, userName, password, isActive) VALUES (:firstName,:lastName,:userName,:password,1)";
    $stmt = $conn->prepare($query);
    $stmt->execute(['firstName' => $firstName,'lastName' => $lastName,'userName' => $userName,'password' => $hashedPassword]);

    $insertedId = $conn->lastInsertId();
    
    $querySelect = "SELECT id,firstName,lastName,userName FROM user WHERE  id = :id ";
    $stmtSelect = $conn->prepare($querySelect);
    $stmtSelect->execute(['id' => $insertedId]);

$user =  $stmtSelect->fetch(PDO::FETCH_ASSOC);
    echo json_encode(array('success'=> true, 'data'=>$user));
}else{
    echo json_encode(array('success'=> false,'message' =>"something went wrong"));
}
}catch (exception $e){
    echo json_encode(array("success" => false, "message" => $e));
}
?>