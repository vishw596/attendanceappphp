<?php

class Database
{
    private $servername = "localhost";
    private $username = "vishw_76";
    private $password = "Vkp8989@";
    public $conn = null;
    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=attendance_db;", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $th) {
            echo "Something Went Wrong<br>";
            echo $th->getMessage();
        }
    }
}
