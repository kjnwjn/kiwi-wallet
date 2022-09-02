<?php
require_once('./vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');
class Register extends Controller
{
    function __construct()
    {
        $this->middleware = new ApiMiddleware();
        $payload = $this->middleware->jwt_get_payload();
        $payload ? header('Location: '.getenv('BASE_URL').'') : null;

    }
    function default()
    {
        $this->view('layoutValidate', array(
            'title' => 'register',
            'page' => 'register'
        ));
    }
}
