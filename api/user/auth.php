<?php

    // заголовки
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once "../conf/db.php";
    include_once "../obj/user.php";

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    $data = json_decode(file_get_contents("php://input"));

    $user->id = $data->id;

    // установка значений данных пользователя
    $user->mail = $data->mail;
    $user->password = $data->password;

    $user->auth();

?>
