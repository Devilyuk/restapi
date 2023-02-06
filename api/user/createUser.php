<?php

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

    // получаем данные
    $data = json_decode(file_get_contents("php://input"));

    // проверка данных
    if (!empty($data->name) && !empty($data->mail) && !empty($data->phone) && !empty($data->password)) {
        // данные пользователя
        $user->name = $data->name;
        $user->mail = $data->mail;
        $user->phone = $data->phone;
        // хеширование пароля
        $user->password = password_hash($data->password, PASSWORD_DEFAULT);

        if ($user->createUser()) {
            http_response_code(201);
            echo json_encode(array("message" => "Пользователь создан."), JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Невозможно создать пользователя."), JSON_UNESCAPED_UNICODE);
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Невозможно создать пользователя. Заполните все поля."), JSON_UNESCAPED_UNICODE);
    }

?>