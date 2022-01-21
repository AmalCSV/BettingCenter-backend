<?php
//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database
include_once "../config/constants.php";
include_once "../config/database.php";


if(isset($_GET['date'])){

    $date = $_GET['date'];

    //create query
    $query = "SELECT identifier FROM race WHERE date = :date";

    //prepare the query
    $stmt = $conn->prepare($query);

    //execute the query
    $stmt->execute(['date'=>$date]);

    if($stmt->rowCount() > 0) {

        $users_arr = array();
        $users_arr["race"] = array(); 

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $user_record = array(
            "identifier" => $identifier
        );

        array_push($users_arr["race"], $user_record);

        echo json_encode($users_arr);
}

}