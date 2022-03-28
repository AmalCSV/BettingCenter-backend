<?php
//headers
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

$id = '';
$name = '';
$address = '';
$contactPerson = '';
$phone = '';
$isActive = '';

include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

//create query
$query = "SELECT id, name, address,contactPerson, phone, isActive  FROM bettingCenter ORDER BY id DESC";

//prepare the query statement
$stmt = $conn->prepare($query);

//execute the query
$stmt->execute();

$num = $stmt->rowCount();

//check if more than zero found
if($num > 0){
    //bettingcen_record array
    $bettingcen_arr = array();
    $bettingcen_arr["data"] = array(); 
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
         extract($row);
    
         $bettingcen_record = array(
             "id" => $id,
             "name" =>$name,
             "address" =>$address,
             "contactPerson" =>$contactPerson,
             "phone" =>$phone,
             "isActive" =>$isActive
         );
         //push to data
         array_push($bettingcen_arr["data"], $bettingcen_record);
         $bettingcen_arr["Success"] = true; 
    }

    echo json_encode($bettingcen_arr);
    
    }else{
    $bettingcen_arr["Success"] = false; 
    echo json_encode($bettingcen_arr);  
    }
?>