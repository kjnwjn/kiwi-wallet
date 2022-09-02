<?php

class Security extends Controller
{
    function __construct()
    {
        $payload = $this->jwt_get_payload();
        if (!$payload) {
            header('Location:' . getenv('BASE_URL') . 'login');
            die();
        }
    }

    function default()
    {
        $this->view('Layout', array(
            'title' => 'Home',
            'page' => 'security'
        ));
    }
}
