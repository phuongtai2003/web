<?php
    require_once("../../jobSkillDB.php");
    $job_skill_db = new JobSkillDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support POST method")));
    }

    $id = $_GET['fieldId'] ?? '';
    if(empty($id)){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }

    $res = $job_skill_db->get_skill_by_field($id);

    if($res['code']!=0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $res['error'])));
    }
    die(json_encode(array("status"=> true, "data" => $res['data'])));
?>