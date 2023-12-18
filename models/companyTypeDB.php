<?php
    require_once("connection.php");
    class CompanyTypeDB{
        private mysqli $conn;
        public function __construct(){
            $this->conn = get_connection();
        }
        public function getAllCompTypes(){
            $sql = "select * from companytype";
            $stmt = $this->conn->prepare($sql);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something has gone wrong");
            }
            $data = array();
            $res = $stmt->get_result();
            while($row = $res->fetch_assoc()){
                $data[] = $row;
            }
            return array("code" => 0, "msg" => "Get company types success", "data" => $data);
        }
    }
?>