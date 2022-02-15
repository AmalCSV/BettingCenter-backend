<?php
include_once "../config/header.php";
include_once "../config/constants.php";
include_once "../config/database.php";

try{

if (isset ($_GET ['pageNumber'])) {
    $pageNumber = $_GET['pageNumber'];

}else{
    $pageNumber = 1;
}

$results_per_page = 5;
$offset = ($pageNumber-1) * $results_per_page;

$query = "SELECT * FROM betting LIMIT $offset, $results_per_page";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->rowCount();

$totalNumberOfPages = ceil($result/$results_per_page);

if($pageNumber>$totalNumberOfPages && !($pageNumber=$totalNumberOfPages)){
    echo json_encode(array("success" => false, "message" => "Invalid pageNumber"));

}

elseif($result > 0) {
    $betting_arr = array();
    $betting_arr["data"] = array(); 

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    
    $betting_record = array(
        "id" => $id,
        "customer" =>$customer,
        "bettingDate" =>$bettingDate,
        "bettingCenterId" =>$bettingCenterId,
        "bettingAmount" =>$bettingAmount,
        "calculateBettingAmount" =>$calculateBettingAmount,
        "winningAmount" =>$winningAmount,
        "createdDate" =>$createdDate,
        "createdBy" =>$createdBy
    );

    array_push($betting_arr["data"],$betting_record);  
    $betting_arr["success"] = true;
} 
    echo json_encode($betting_arr);
    
}else{
    $betting_arr["success"] = false; 
}
}catch (exception $e){
    echo json_encode(array("success" => false, "message" => $e));
}

?>

