<?php
    require_once("connection.php");
    class JobSkillDB{
        private mysqli $conn;
        public function __construct(){
            $this->conn = get_connection();
        }
        public function get_skill_data(){
            $sql = "select * from jobskills";
            $stmt= $this->conn->prepare($sql);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $data = array();
            $res = $stmt->get_result();
            while($row = $res->fetch_assoc()){
                $data[] = $row;
            }
            return array("code" => 0, "msg" => "Fetch data successfully" ,"data" => $data);
        }
        public function get_skill_by_field($field_id){
            $sql = "select * from jobfield where JobFieldId = ?";
            $stmt= $this->conn->prepare($sql);
            $stmt->bind_param("i", $field_id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows == 0){
                return array("code" => 2, "error" => "Field does not exist");
            }

            $sql = "select * from jobskills where JobFieldId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $field_id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            
            $res = $stmt->get_result();
            $data = array();
            while($row = $res->fetch_assoc()){
                $data[] = $row;
            }
            return array("code" => 0, "msg" => "Fetch data successfully" ,"data" => $data);
        }
    }
?>