<?php
    require_once("connection.php");
    class JobLocationTypeDB{
        private mysqli $conn;
        public function __construct(){
            $this->conn = get_connection();
        }
        public function get_location_type(){
            $sql = "select * from joblocationtype";
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
        public function get_location_by_id($id){
            $sql = "select * from joblocationtype where JobLocationTypeId = ?";
            $stmt= $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
           
            $res = $stmt->get_result();
            if($res->num_rows != 1){
                return array("code" => 2, "error" => "Location type does not exist");
            }
            $data = $res->fetch_assoc();
            return array("code" => 0, "msg" => "Fetch data successfully" ,"data" => $data);
        }
    }
?>