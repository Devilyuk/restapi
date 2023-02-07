<?php

    // заголовки
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header("Content-Type: application/json");

    include_once "../conf/db.php";
    include_once "../obj/user.php";

    $database = new Database();
    $db = $database->getConnection();
    $data = json_decode(file_get_contents("php://input"));

    $user = new User($db);

    $user->id = isset($_GET["id"]) ? $_GET["id"] : die();

    $user->search();

    if ($user->name != null) {
        $user_data_arr = array(
            "id" =>  $user->id,
            "name" => $user->name,
            "mail" => $user->mail,
            "phone" => $user->phone
        );

        // ответ сервера при успешном получении данных
        http_response_code(200);
        echo json_encode($user_data_arr);
    } else {
        // ответ сервера при ошибке
        http_response_code(404);
        echo json_encode(array("message" => "Такого пользователя нет в базе"), JSON_UNESCAPED_UNICODE);
    }

?>
