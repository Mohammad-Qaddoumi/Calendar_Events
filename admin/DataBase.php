<?php
class DataBase {
    private $db_name = "testdata";
    private $sql_name = "root";
    private $sql_pass = "";
    private $server_name = "localhost";
    public function connect(){
        $con = mysqli_connect($this->server_name, $this->sql_name, $this->sql_pass, $this->db_name);
    
        if (!$con) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        } else {
            return $con;
        }
    }
    public function PDOConnection(){
        $con = new PDO("mysql:host=$this->server_name;dbname=$this->db_name",$this->sql_name,$this->sql_pass);

        return $con;
    }
}
?>