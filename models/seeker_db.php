<?php
    require_once("./models/connection.php");
    require_once("./models/utils.php");
    class SeekerDB{
        private mysqli $conn;
        public function __construct(){
            $this->conn = get_connection();   
        }

        public function register($email, $password, $firstname, $lastname, $birthdate, $nationality, $province){
            $emailExist = $this->email_exist($email);
            if($emailExist){
                return array("code" => 2, "error" => "Email has already existed");
            }
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $token = md5($email.'+'.rand(0, 100));
            $sql = "INSERT INTO seeker (SeekerEmail, SeekerPassword, SeekerFirstName, SeekerLastName, SeekerBirthDate, SeekerNationality, SeekerProvince, activateToken) VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssssss", $email, $hashed_password, $firstname, $lastname, $birthdate, $nationality, $province, $token);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Could not connect to database");
            }
            send_activation_email($email, $token);
            return array("code" => 0, "msg" => "Account created successfully");
        }
        public function activate_account($email, $token){
            $sql = "select * from seeker where SeekerEmail = ? AND activateToken = ? AND activated = 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $email, $token);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "There has been an error occurred");
            }
            $res = $stmt->get_result();
            if($res->num_rows == 0){
                return array("code" => 2, "error"=> "Account is already activated or email or token does not exist");
            }
            $sql = "update seeker set activated = 1, activateToken = '' where SeekerEmail = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $email);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "There has been an error occurred");
            }
            return array("code" => 0, "msg" => "Account activated successfully");
        }
        private function email_exist($email){
            $sql = "select * from seeker where SeekerEmail = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $email);
            if(!$stmt->execute()){
                return null;
            }
            $res = $stmt->get_result();
            if($res -> num_rows >=1 ){
                return true;
            }
            return false;
        }
    }
?>