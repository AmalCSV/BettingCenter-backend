<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

    $queryRead = "SELECT id,companyName,address,tax,extendedJson FROM settings WHERE id=1";
    $stmt = $conn->prepare($queryRead);
    $stmt->execute();
    $num = $stmt->rowCount();
    $settingsArray = array();
    $settingsArray["data"] = array(); 
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
         extract($row);
         $settings = array(
             "id" => $id,
             "companyName" =>$companyName,
             "address" =>$address,
             "tax" =>$tax,
             "extendedJson" =>$extendedJson,
         );
         $settingsArray["data"] = $settings;
    }
    $settingsArray["success"] = true; 
    echo json_encode($settingsArray, FALSE);
?>
