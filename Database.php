<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "tms_db";
    private $conn;

    public function __construct() {
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function escape_string($string) {
        return $this->conn->real_escape_string($string);
    }

    public function insert_id() {
        return $this->conn->insert_id;
    }

    public function affected_rows() {
        return $this->conn->affected_rows;
    }

    public function error() {
        return $this->conn->error;
    }

    public function close() {
        $this->conn->close();
    }
} 