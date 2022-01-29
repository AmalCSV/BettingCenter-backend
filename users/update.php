<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"));

    $id = $data->id;
    $firstName = $data->firstName;
    $lastName = $data->lastName;
    $userName = $data->userName;
    $password = $data->password;
    $isActive = $data->isActive;

    if(isset($id) && isset($firstName) && isset($lastName) && isset($userName) && isset($password) && isset($isActive)){

    $updateQuery = "UPDATE user SET firstName = :firstName, lastName = :lastName, userName = :userName, isActive = :isActive, password = :password WHERE
     id = :id";

    $stmt = $conn->prepare($updateQuery);

    //sanitize data(clean up for security)

    $id = htmlspecialchars(strip_tags($id));
    $firstName = htmlspecialchars(strip_tags($firstName));
    $lastName = htmlspecialchars(strip_tags($lastName));
    $userName = htmlspecialchars(strip_tags($userName));
    $password = htmlspecialchars(strip_tags($password));
    $isActive = htmlspecialchars(strip_tags($isActive));


    $stmt->execute(['id' =>$id,'firstName' => $firstName,'lastName' => $lastName,'userName' => $userName,'password' => $password,'isActive' => $isActive]);

    echo json_encode(array("message" => "User was updated."));
    }

    else{
        echo json_encode(array("message" => "User was not updated."));
    }

