<?php
class Database
{
    //Trương Lê Minh Nhật - 2180604923
    private $host = "localhost";
    private $db_name = "test1";
    private $username = "root";
    private $password = "nhocvip02";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
