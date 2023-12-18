<?php
    $companies_list = array();
    $error = "";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/review/getTopRated.php");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));
    $result = json_decode(curl_exec($ch),true);
    curl_close($ch);
    if($result['status']){
        $companies_list = $result['data'];
    }
    else{
        $error = $result['error'];
    }
    include_once("./view/companies.php");
?>