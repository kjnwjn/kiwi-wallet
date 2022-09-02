<?php
require_once('./vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class Home extends Controller
{

    function __construct()
    {
        $this->middleware = new ApiMiddleware();
        
    }
    function default()
    {
        $payload = $this->middleware->jwt_get_payload();
        if($payload) {   
            $this->view('Layout', array(
                'title' => 'Home',
                'page' => 'home',
                'respone' => $payload
            ));
            die();
        };
        $this->view('Layout', array(
            'title' => 'Home',
            'page' => 'home'
        ));
    }
}
