<?php
class NganhHocModel
{
    private $conn;
    private $table_name = "nganhhoc";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllNganhHoc()
    {
        $query = "SELECT MaNganh, TenNganh FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    public function getNganhHocById($MaNganh)
    {
        $query = "SELECT TenNganh FROM " . $this->table_name . " WHERE MaNganh = :MaNganh";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':MaNganh', $MaNganh);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
}
