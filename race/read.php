<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

$id = '';
$name = '';
$identifier = '';
$date = '';
$description = '';
$extendedJson = '';
$createdBy	 = '';
$createdDate = '';
$isDeleted = '';
$isIndividual = false;

if(isset($_GET['id'])) {
    $isIndividual = true;
    $id = $_GET['id'];
    $query = "SELECT id, name, identifier, date, description,extendedJson, createdBy, createdDate, isDeleted FROM race WHERE id= :id  and isDeleted != 1 ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute(['id' => $id]); 
} else {
    $query = "SELECT id, name, identifier, date, description,extendedJson, createdBy, createdDate, isDeleted FROM race  WHERE isDeleted != 1 ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
}

$num = $stmt->rowCount();

if($num > 0){
    // array
    $race_arr = array();
    $race_arr["data"] = array(); 
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
         extract($row);
    
         $race_record = array(
             "id" => $id,
             "name" =>$name,
             "identifier" =>$identifier,
             "date" => $date,
             "description" =>$description,
             "extendedJson" =>$extendedJson,
             "createdBy" =>$createdBy,
             "createdDate" =>$createdDate,
             "isDeleted" =>$isDeleted
         );
    
         //push to data
         array_push($race_arr["data"], $race_record);
         $race_arr["Success"] = true; 
    }
    if($isIndividual) {
        $race_arr["data"] = $race_arr["data"][0];
    }
    echo json_encode($race_arr);
    
    }else{

    $race_arr["Success"] = false; 
    echo json_encode($race_arr);    
}
?>