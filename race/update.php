<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"));

try{
    $id = $data->id;    
    $name = $data->name;
    $identifier = $data->identifier;
    $date = $data->date;
    $description = $data->description;
    $extendedJson = $data->extendedJson;
    $createdBy = $data->createdBy;
    $createdDate = $data->createdDate;

    if(isset($id) && isset($name) && isset($identifier) && isset($date) && isset($description) && isset($extendedJson) && isset($createdBy) && isset($createdDate)){

    $updateQuery = "UPDATE race SET name = :name, identifier = :identifier, date = :date, description = :description, extendedJson = :extendedJson, createdBy = :createdBy, createdDate = :createdDate WHERE id = :id";

    $stmt = $conn->prepare($updateQuery);

    $id = htmlspecialchars(strip_tags($id));
    $name = htmlspecialchars(strip_tags($name));
    $identifier = htmlspecialchars(strip_tags($identifier));
    $date = htmlspecialchars(strip_tags($date));
    $description = htmlspecialchars(strip_tags($description));
    $extendedJson = htmlspecialchars(strip_tags($extendedJson));
    $createdBy = htmlspecialchars(strip_tags($createdBy));
    $createdDate = htmlspecialchars(strip_tags($createdDate));

    $stmt->execute(['id' => $id,'name' => $name,'identifier' => $identifier, 'date' => $date,'description' => $description, 'extendedJson' => $extendedJson,'createdBy' => $createdBy,'createdDate' => $createdDate]);

    echo json_encode(array("success"=> true, "message" => "Race was updated."));
    }

    else{
        echo json_encode(array("success"=> false, "message" => "Race was not updated.")); 
    }
}catch(exception $e){
    echo json_encode(array("success"=>false,"message"=>$e));
}
?>
