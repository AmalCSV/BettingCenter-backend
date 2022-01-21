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
    $query = "SELECT id,name,address,contactPerson,phone,isActive FROM bettingcenter WHERE id= :id AND isActive = 1 ";

    //prepare the query
    $stmt = $conn->prepare($query);

    //execute the query
    $stmt->execute(['id'=>$id]);

    if($stmt->rowCount() > 0) {

        $BettingCen_arr = array();
        $BettingCen_arr["data"] = array(); 

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        
        $BettingCen_record = array(
            "id" => $id,
            "name" =>$name,
            "address" =>$address,
            "contactPerson" =>$contactPerson,
            "phone" =>$phone
        );

        array_push($BettingCen_arr["data"], $BettingCen_record);
        $BettingCen_arr["Success"] = true; 

        echo json_encode($BettingCen_arr);

    } else{

        $BettingCen_arr["Success"] = false; 
        echo json_encode($BettingCen_arr);
    }

    $stmt->closeCursor();

}