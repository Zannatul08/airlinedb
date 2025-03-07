<?php
class Database {
    private static $instance = null; // Holds the single instance
    private $connection;            // Holds the database connection

    // Private constructor to prevent direct instantiation
    private function __construct() {
        $this->connection = new mysqli("localhost", "root", "", "airlinedb");

        if ($this->connection->connect_error) {
            die("Database connection failed: " . $this->connection->connect_error);
        }
    }

    // Public static method to get the instance
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Method to get the connection object
    public function getConnection() {
        return $this->connection;
    }
}
?>


