<?php
    class Database {
        private $host = "localhost";
        private $db_name = "api";
        private $user = "root";
        private $pass = "";
        public $conn;

        // соединение с базой
        public function getConnection() {
            $this->conn = null;

            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->user, $this->pass);
                $this->conn->exec("set names utf8");
            } catch (PDOException $exception) {
                echo "Ошибка подключения: " . $exception->getMessage();
            }

            return $this->conn;
        }
    }
?>