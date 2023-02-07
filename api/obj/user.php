<?php

    class User {
        private $conn;
        private $table_name = "users";

        public $id;
        public $name;
        public $mail;
        public $phone;
        public $password;

        // конструктор для соединения с БД
        public function __construct($db) {
            $this->conn = $db;
        }

        // метод создания пользователей
        function createUser() {
            $query = "INSERT INTO " . $this->table_name . " SET name=:name, mail=:mail, phone=:phone, password=:password";
            $req = $this->conn->prepare($query);

            $req->bindParam(":name", $this->name);
            $req->bindParam(":mail", $this->mail);
            $req->bindParam(":phone", $this->phone);
            $req->bindParam(":password", $this->password);

            if ($req->execute()) {
                return true;
            }
            return false;
        }

        // метод получения данных пользователя по ID
        function search() {
            $sql = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
            $req = $this->conn->prepare($sql);
            $req->bindParam(1, $this->id);

            $req->execute();
            $row = $req->fetch(PDO::FETCH_ASSOC);

            $this->id = $row["id"];
            $this->name = $row["name"];
            $this->mail = $row["mail"];
            $this->phone = $row["phone"];
        }

        // метод обновления данных пользователя
        function updateUser() {
            $sql = "UPDATE " . $this->table_name . " SET name = ?, mail = ?, phone = ? WHERE id = ?";

            $req = $this->conn->prepare($sql);

            $req->bindParam(1, $this->name);
            $req->bindParam(2, $this->mail);
            $req->bindParam(3, $this->phone);
            $req->bindParam(4, $this->id);

            if ($req->execute()) {
                return true;
            }
            return false;
        }

        // метод удаления пользователя
        function delete() {
            $sql = "DELETE FROM " . $this->table_name . " WHERE id = ?";
            $req = $this->conn->prepare($sql);
            $req->bindParam(1, $this->id);

            if ($req->execute()) {
                return true;
            }
            return false;
        }

        // метод авторизации
        function auth() {
            $sql = "SELECT mail, password FROM " . $this->table_name . " WHERE mail = ?";
            $req = $this->conn->prepare($sql);
            $req->bindParam(1, $this->mail);
            
            $req->execute();
            $row = $req->fetch(PDO::FETCH_ASSOC);

            if ($row['mail'] == $this->mail) {
                if (password_verify($this->password, $row['password'])) {
                    http_response_code(200);
                    echo json_encode(array("message" => "Вы успешно авторизировались!</p>"), JSON_UNESCAPED_UNICODE);
                } else {
                    http_response_code(200);
                    echo json_encode(array("message" => "Пароль не подходит!"), JSON_UNESCAPED_UNICODE);
                }
            } else {
               echo json_encode(array("message" => "Пользователя с такой почтой не существует! " . $row['mail'] . " " . $this->mail), JSON_UNESCAPED_UNICODE);
            }
        }
    }

?>
