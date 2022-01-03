<?php
//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database
include_once "../config/constants.php";
include_once "../config/database.php";


if(isset($_GET['id'])){

    $id = $_GET['id'];

    //create query
    $query = "SELECT firstName, lastName, userName FROM user WHERE id= :id AND isActive = 1 ";

    //prepare the query
    $stmt = $conn->prepare($query);

    //execute the query
    $stmt->execute(['id'=>$id]);

    if($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);

    } else{

        echo json_encode(array("message"=>"No Active User Found"));
    }

    $stmt->closeCursor();

}


