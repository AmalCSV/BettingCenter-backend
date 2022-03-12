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
    $id = $row['id'];
    $firstname = $row['firstName'];
    $lastname = $row['lastName'];
    $username = $row['userName'];

    $secret_key = "BETTING_CORE";
    $issuer_claim = "ADR_SERVER"; // this can be the servername
    $audience_claim = "MILAN";
    $issuedat_claim = time(); // issued at
    $notbefore_claim = $issuedat_claim + 10; //not before in seconds
    $expire_claim = $issuedat_claim + 60000; // expire time in seconds
    $token = array(
        "iss" => $issuer_claim,
        "aud" => $audience_claim,
        "iat" => $issuedat_claim,
        "nbf" => $notbefore_claim,
        "exp" => $expire_claim,
        "data" => array(
            "id" => $id,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "username" => $username
    ));

    //$jwt = JWT::encode($token, $secret_key);
    $data = array(
            "message" => "Successful login.",
            "jwt" =>  '', //$jwt,
            "id" => $id,
            "userName" => $username,
            "expireAt" => $expire_claim,
            "firstName" => $firstname,
            "lastName" => $lastname,
    );

    echo json_encode(array('success'=> true, 'data'=>$data ));
}else{
    echo json_encode(array('success'=> false,'message' =>"Login Failed"));

}