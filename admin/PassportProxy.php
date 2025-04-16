<?php
require_once '../db_connection.php';

class PassportProxy
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function isBanned($passport_number)
    {
        $sql = "SELECT * FROM banned_passports WHERE passport_number = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $passport_number);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function banPassport($passport_number)
    {
        $sql = "INSERT IGNORE INTO banned_passports (passport_number) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $passport_number);
        return $stmt->execute();
    }
}
?>