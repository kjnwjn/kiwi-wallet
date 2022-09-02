<?php
require_once('./vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Dashboard extends Controller
{
    protected $middleware;

    function __construct()
    {
        $this->middleware = new ApiMiddleware();
        $payload = $this->middleware->jwt_get_payload();
        if($payload && $payload->phoneNumber != 'admin') {   
            $this->view('LayoutError', array(
                'title' => 'Forbidden',
                'error_code' => '403',
                'error_Content' => 'FORBIDDEN. YOU DO NOT HAVE PERMISSION TO ACCESS THIS PAGE.'
            ));
            die();
        };
    }

    function default()
    {
        $this->view('LayoutAdmin', array(
            'title' => 'Dashboard',
            'page' => 'Dashboard'
        ));
    }
    function listAccount()
    {
        $this->view('LayoutAdmin', array(
            'title' => 'List Accounts',
            'page' => 'listAccount'
        ));
    }
    function listTransactions()
    {
        $this->view('LayoutAdmin', array(
            'title' => 'List Transactions',
            'page' => 'listTransaction'
        ));
    }
    function listAllTransaction()
    {
        $this->view('LayoutAdmin', array(
            'title' => 'List All Transactions',
            'page' => 'listAllTransaction'
        ));
    }
}
