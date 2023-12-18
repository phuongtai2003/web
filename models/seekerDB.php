<?php
    require_once("connection.php");
    require_once("utils.php");
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
        public function login($email, $password){
            $sql = "select * from seeker where SeekerEmail = ? and activated = 1";
            $stmt =  $this->conn->prepare($sql);
            $stmt->bind_param("s", $email);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "There has been an error occurred");
            }
            $res = $stmt -> get_result();
            if($res->num_rows != 1){
                return array("code" => 2, "error" => "Email does not exist or is not activated");
            }
            $hashed_password = '';
            $data = null;
            while($row = $res->fetch_assoc()){
                $hashed_password = $row['SeekerPassword'];
                $data = $row;
            }
            if(!password_verify($password, $hashed_password)){
                return array("code" => 3, "error" => "Password is not correct");
            }
            return array("code" => 0, "msg" => "Login successfully", "data" => $data);
        }
        public function upload_cv($cv_url, $id){
            $sql = "update seeker set SeekerCV = ? where SeekerId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("si",$cv_url, $id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            return array("code" => 0, "msg" => "Upload CV Successfully");
        }
        public function get_seeker_data($id){
            $sql = "select * from seeker where SeekerId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows == 0){
                return array("code" => 2, "error" => "User does not exist");
            }
            $data = $res->fetch_assoc();
            return array("code" => 0, "msg" => "Retrieve Seeker Data successfully", "data" => $data);
        }
        public function update_seeker($id, $firstname, $lastname, $email, $birth_date, $nationality, $province){
            $sql = "update seeker set SeekerFirstName = ?, SeekerLastName = ?, SeekerEmail = ?, SeekerBirthDate = ?, SeekerNationality = ?, SeekerProvince = ? where SeekerId = ?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("ssssssi", $firstname, $lastname, $email, $birth_date, $nationality, $province, $id);
            if(!$stmt->execute()){
                return array("code"=> 1, "error" => "Something went wrong");
            }
            if($stmt->affected_rows != 1){
                return array("code"=> 2, "error" => "Seeker does not exist");
            }
            return array("code" => 0, "msg" => "Update seeker information successfully");
        }
        public function change_password($id, $old_password, $new_password){
            $sql = "select * from seeker where SeekerId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows != 1){
                return array("code" => 2, "error" => "User does not exist");
            }
            $seeker_data = $res->fetch_assoc();
            $isValid =  password_verify($old_password, $seeker_data['SeekerPassword']);
            if($isValid){
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "update seeker set SeekerPassword = ? where SeekerId = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("si", $new_hashed_password, $id);
                if(!$stmt->execute()){
                    return array("code" => 1, "error" => "Something went wrong");
                }
                return array("code" => 0, "msg" => "Changed password successfully");
            }
            else{
                return array("code" => 3, "error" => "Old password does not match");
            }
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
            $sql = "select * from company where CompanyEmail = ?";
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