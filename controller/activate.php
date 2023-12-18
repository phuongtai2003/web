<?php
    require_once("./models/seekerDB.php");
    require_once("./models/companyDB.php");
    $seeker_database = new SeekerDB();
    $company_database = new CompanyDB();
    $error = "";
    $msg = "";
    $email = $_GET['email']?? '';
    $token = $_GET['token'] ??'';
    if(empty($email) || empty($token)){
        $error = "Either Email or Token is empty";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Wrong email format";
    }
    else if(strlen($token) != 32){
        $error = "Wrong token format";
    }
    else{
        $res = $seeker_database->activate_account($email, $token);
        if($res['code'] == 0){
            $msg = $res['msg'];
        }
        else{
            $res = $company_database->activate_account($email, $token);
            if($res['code'] == 0){
                $msg = $res['msg'];
            }
            else{
                $error = $res['error'];
            }
        }
    }
    require_once("./view/activate.php");
?>