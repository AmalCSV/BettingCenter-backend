<?php
function isValidData ($field, $data) {
    if ($data[$field]) {
        return $data[$field];
     } 
     else {
         return null;
     }
}

function output($success, $message, $data ) {
    $outputArray = array("success"=> $success);
    if(is_null($message)){
        $outputArray["message"] = $message;
    } else {
        $outputArray["data"] = $data;
    }

    echo json_encode($outputArray);
}

?>