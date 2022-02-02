<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $queryRead = " SELECT id,firstName, lastName, userName FROM user WHERE isActive = 1 AND id =:id ORDER BY id DESC ";
        $stmt = $conn->prepare($queryRead);
        $stmt->execute(['id' => $id]); 
    } else {
        $queryRead = " SELECT id,firstName, lastName, userName FROM user WHERE isActive = 1 ORDER BY id DESC ";
        $stmt = $conn->prepare($queryRead);
        $stmt->execute();
    }

    $num = $stmt->rowCount();
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
         array_push($users_arr["data"], $user_record);
    }
    if(count($users_arr["data"]) == 1){
        $users_arr["data"] = $users_arr["data"][0];
    } 
    $users_arr["success"] = true; 
    echo json_encode($users_arr, FALSE);
    ?>