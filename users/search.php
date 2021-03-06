<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $query = "SELECT firstName, lastName, userName FROM user WHERE id= :id AND isActive = 1 ";

    $stmt = $conn->prepare($query);

    $stmt->execute(['id'=>$id]);

    if($stmt->rowCount() > 0) {

        $users_arr = array();
        $users_arr["data"] = array(); 

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        
        $user_record = array(
            "id" => $id,
            "firstName" =>$firstName,
            "lastName" =>$lastName,
            "userName" =>$userName
        );

        $users_arr["data"] = $user_record;
        $users_arr["success"] = true; 

        echo json_encode($users_arr);

    } else{

        $users_arr["success"] = false; 
        echo json_encode($users_arr);
    }

    $stmt->closeCursor();
}

?>
