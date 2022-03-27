<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

    $queryRead = "SELECT id,name FROM role ORDER BY id";
    $stmt = $conn->prepare($queryRead);
    $stmt->execute();
    $num = $stmt->rowCount();
    $roleArray = array();
    $roleArray["data"] = array(); 
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
         extract($row);
         $role = array(
             "id" => $id,
             "name" =>$name,
         );
         array_push($roleArray["data"], $role);
    }
    $roleArray["success"] = true; 
    echo json_encode($roleArray, FALSE);
?>
