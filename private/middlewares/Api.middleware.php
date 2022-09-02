<?php
require_once('./vendor/autoload.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiMiddleware
{
    function request_method($type)
    {
        if ($_SERVER['REQUEST_METHOD'] !== strtoupper($type)) {
            http_response_code(405);
            echo json_encode([
                'status' => false,
                'errCode' => 405,
                'msg' => 'Method not allowed!'
            ]);
            die();
        }
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

    function json_send_response($status = 200, $array = [])
    {
        http_response_code($status);
        echo json_encode($array);
        die();
    }

    function authentication()
    {
        try {
            $jwt = isset($_COOKIE['JWT_TOKEN']) ? $_COOKIE['JWT_TOKEN'] : null;
            JWT::decode($jwt, new Key(getenv('SECRET_KEY'), 'HS256'));
        } catch (\Throwable $th) {
            $this->json_send_response(401, array(
                'status' => false,
                "header_status_code" => 401,
                'msg' => 'Unauthorized. Permission dennied.'
            ));
            
        }
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
