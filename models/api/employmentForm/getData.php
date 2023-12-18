<?php
    require_once("../../employmentFormDB.php");
    $employment_form_db = new EmploymentFormDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support POST method")));
    }
    $res = $employment_form_db->get_form_data();

    if($res['code']!=0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $res['error'])));
    }
    die(json_encode(array("status"=> true, "data" => $res['data'])));
?>