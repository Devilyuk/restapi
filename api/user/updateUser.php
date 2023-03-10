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
    $user->name = $data->name;
    $user->mail = $data->mail;
    $user->phone = $data->phone;

    if ($user->updateUser()) {
        http_response_code(200);
        echo json_encode(array("message" => "Данные успешно обновлены"), JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Невозможно обновить данные"), JSON_UNESCAPED_UNICODE);
    }

?>