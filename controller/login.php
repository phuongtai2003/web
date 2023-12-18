<?php
    if(isset($_SESSION['accountType']) && !empty($_SESSION['accountType'])){
        header("Location: index.php");
    }
    $error = "";
    if(isset($_POST['type'])){
        $login_type = $_POST['type'];
        $email = $_POST['email'] ?? '';
        $password = $_POST['pwd'] ?? '';
        $data = json_encode(array("email" => $email, "password" => $password));
        if(empty($email) || empty($password)){
            $error ="Some fields are left empty";
        }
        else if($login_type === 'seeker'){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/login/seekerLogin.php");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));
            $res = json_decode(curl_exec($ch));
            if($res->status == true){
                $_SESSION['userId'] = $res->data->SeekerId;
                $_SESSION['accountType'] = 'seeker';
                header("Location: index.php");
            }
            else{
                $error = $res->error;
            }
        }
        else if($login_type === 'company'){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/login/companyLogin.php");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));
            $res = json_decode(curl_exec($ch));
            if($res->status == true){
                $_SESSION['userId'] = $res->data->CompanyId;
                $_SESSION['accountType'] = 'company';
                header("Location: index.php");
            }
            else{
                $error = $res->error;
            }        
        }
    }
    include_once("./view/login.php");
?>