<?php
    require_once('./models/cloudinaryControl.php');
    if(empty($role)){
        header("location:index.php");
    }

    $error_company = "";
    $error_seeker = "";
    $msg_company = "";
    $msg_seeker = "";
    if(isset($_POST['update-seeker-info']) && $_POST['update-seeker-info'] === 'update'){
        $firstname = $_POST['firstname'] ?? '';
        $lastname = $_POST['lastname'] ?? '';
        $email = $_POST['email'] ?? '';
        $birthdate = $_POST['birth-date'] ?? '';
        $nationality = $_POST['country'] ?? '';
        $province = $_POST['province'] ?? '';
        if(empty($firstname) || empty($lastname) || empty($email) || empty($birthdate) || empty($nationality) || empty($province)){
            $error_seeker = "Update unsuccessfully due to empty fields";
        }
        else{
            $ch = curl_init();
            $data = json_encode(array("firstname" => $firstname, "lastname" => $lastname, "email" => $email, "birthdate" => $birthdate, "nationality" => $nationality, "province" => $province));
            curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/seeker/updateSeeker.php?userId=".$_SESSION['userId']);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $result = json_decode(curl_exec($ch), true);
            if($result['status']){
                $msg_seeker = $result['msg'];
            }
            else{
                $error_seeker = $result['error'];
            }
        }
    }
    if(isset($_POST['update-company-info']) && $_POST['update-company-info'] === 'update'){
        $company_name = $_POST['company-name'] ?? '';
        $company_desc = nl2br($_POST['company-description'] ?? '');
        $date_created = $_POST['date-created'] ?? '';
        $email = $_POST['email'] ?? '';
        $country = $_POST['country'] ?? '';
        $province = $_POST['province'] ?? '';
        $company_type = $_POST['company-type'] ?? '';

        if(empty($company_name) || empty($company_desc) || empty($date_created) || empty($email) || empty($country) || empty($province) || empty($company_type)){
            $error_company = "Update unsuccessfully due to empty fields";
        }
        else{
            $ch = curl_init();
            $data = json_encode(array("companyName" => $company_name, "companyDesc" => $company_desc, "dateCreated" => $date_created, "email" => $email, "country" => $country, "province" => $province, "compType" => $company_type));
            curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/company/updateCompany.php?userId=".$_SESSION['userId']);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            $result = json_decode(curl_exec($ch), true);
            if($result['status']){
                $msg_company = $result['msg'];
            }
            else{
                $error_company = $result['error'];
            }
        }
    }
    if(isset($_POST['save-image-company']) && !empty($_POST['save-image-company'])){
        if(!isset($_FILES['file-image']) || $_FILES['file-image']['error'] != 0 ){
            $error_company = "No files were chosen";
        }
        else{
            $supportedExt = array("jpg", "png", "svg", "apng", "avif", "gif", "webp");
            $extension = pathinfo($_FILES['file-image']['name'], PATHINFO_EXTENSION);
            if(!in_array($extension, $supportedExt)){
                $error_company = "The file is not supported";
            }
            else{
                $temp_file = $_FILES['file-image']['tmp_name'];
                $res = upload_file($temp_file);
                $company_id = $_SESSION['userId'];
                $data = json_encode(array("image" => $res));
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/company/saveCompanyImage.php?userId=".$_SESSION['userId']);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $result = json_decode(curl_exec($ch), true);
                if($result['status']){
                    $msg_company = $result['msg'];
                }
                else{
                    $error_company = $result['error'];
                }
            }
        }
    }
    if(isset($_POST['save-seeker-cv']) && !empty($_POST['save-seeker-cv'])){
        if(!isset($_FILES['upload-file']) || $_FILES['upload-file']['error'] != 0){
            $error_seeker = "No files were chosen";
        }
        else{
            $supportedExt = array("jpg", "png", "svg", "apng", "avif", "gif", "webp", "pdf", "docx", "doc");
            $extension = pathinfo($_FILES['upload-file']['name'], PATHINFO_EXTENSION);
            if(!in_array($extension, $supportedExt)){
                $error_seeker = "The file is not supported";
            }
            else{
                $temp_file = $_FILES['upload-file']['tmp_name'];
                $res = upload_file($temp_file);
                $seeker_id = $_SESSION['userId'];
                $data = json_encode(array("cv" => $res));
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/seeker/saveSeekerCV.php?userId=".$_SESSION['userId']);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $result = json_decode(curl_exec($ch), true);
                if($result['status']){
                    $msg_seeker = $result['msg'];
                }
                else{
                    $error_seeker = $result['error'];
                }
            }
        }
    }
    if(isset($_POST['change-seeker-password']) && $_POST['change-seeker-password'] === "update"){
        $old_password = $_POST['old-password'] ?? '';
        $new_password = $_POST['new-password'] ?? '';
        $new_password_confirm = $_POST['new-password-confirm'] ?? '';
        if(empty($old_password) || empty($new_password) || empty($new_password_confirm)){
            $error_seeker = "Do not left any password fields empty";
        }
        else if($new_password !== $new_password_confirm){
            $error_seeker = "New passwords do not match";
        }
        else{
            $data = json_encode(array(
                "old_password" => $old_password,
                "new_password" => $new_password,
                "new_confirm_password" => $new_password_confirm
            ));

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/seeker/changePassword.php");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json,' ,'X-Auth-Token: '.$_SESSION['userId']));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $return_result = json_decode(curl_exec($ch), true);
            if($return_result['status']){
                $msg_seeker = $return_result['msg'];
            }
            else{
                $error_seeker = $return_result['error'];
            }
        }
    }

    if(isset($_POST['change-company-password']) && $_POST['change-company-password'] === "update"){
        $old_password = $_POST['old-password'] ?? '';
        $new_password = $_POST['new-password'] ?? '';
        $new_password_confirm = $_POST['new-password-confirm'] ?? '';
        if(empty($old_password) || empty($new_password) || empty($new_password_confirm)){
            $error_company = "Do not left any password fields empty";
        }
        else if($new_password !== $new_password_confirm){
            $error_company = "New passwords do not match";
        }
        else{
            $data = json_encode(array(
                "old_password" => $old_password,
                "new_password" => $new_password,
                "new_confirm_password" => $new_password_confirm
            ));

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/seeker/changePassword.php");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json,' ,'X-Auth-Token: '.$_SESSION['userId']));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $return_result = json_decode(curl_exec($ch), true);
            if($return_result['status']){
                $msg_company = $return_result['msg'];
            }
            else{
                $error_company = $return_result['error'];
            }
        }
    }
    
    $seeker_data = array();
    $company_data = array();
    $applied_jobs_data = array();
    if($role == "seeker"){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/seeker/getData.php?userId=".$_SESSION['userId']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        $res = json_decode(curl_exec($ch), true);
        if($res['status']){
            $seeker_data = $res['data'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/application/getApplicationByUser.php");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'X-Auth-Token: '.$_SESSION['userId']
            ));
            $result = json_decode(curl_exec($ch),true);
            if($result['status']){
                $applied_jobs_data = $result['data'];
            }
            else{
                $error_seeker = $result['error'];
            }
        }
        else{
            $error_seeker = $res['error'];
        }
        require_once("./view/seeker_panel.php");
    }
    else if($role == "company"){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/company/getData.php?userId=".$_SESSION['userId']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        $res = json_decode(curl_exec($ch), true);
        if($res['status']){
            $company_data = $res['data'];
        }
        require_once("./view/company_panel.php");
    }
?>