<?php
require_once('./vendor/autoload.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Controller
{
    function model($model)
    {
        require_once './private/model/' . $model . '.php';
        return new $model;
    }

    function view($view, $data = [])
    {
        require_once './private/view/' . $view . '.php';
    }

    function utils()
    {
        require_once './private/utils/utils.php';
        return new Util;
    }

    function error_handler($status = 500, $message = "Internal Server Error")
    {
        http_response_code($status);
        echo json_encode([
            'status' => false,
            "header_status_code" => $status,
            'msg' => $message
        ]);
        die();
    }

    function jwt_get_payload()
    {
        try {
            $jwt = isset($_COOKIE['JWT_TOKEN']) ? $_COOKIE['JWT_TOKEN'] : null;
            return JWT::decode($jwt, new Key(getenv('SECRET_KEY'), 'HS256'));
        } catch (\Throwable $th) {
            return false;
        }
    }
}
