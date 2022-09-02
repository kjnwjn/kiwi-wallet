<?php
require_once('./private/apis/Account.api.php');
require_once('./private/apis/Card.api.php');
require_once('./private/apis/Service.api.php');
require_once('./private/apis/Transaction.api.php');
require_once('./private/apis/Admin.api.php');

class Api extends Controller
{
    function __construct()
    {
        header('Content-Type: application/json');
    }

    function default()
    {
        $this->error_handler(404, 'This endpoint cannot be found, please contact adminstrator for more information!');
    }

    function account($route = "", $param = "")
    {
        new AccountApi($route, $param);
    }

    function card($route = "", $param = "")
    {
        new CardApi($route, $param);
    }

    function service($route = "", $param = "")
    {
        new ServiceApi($route, $param);
    }

    function transaction($route = "", $param = "")
    {
        new transactionApi($route, $param);
    }

    function admin($route = "", $param = "")
    {
        new AdminApi($route, $param);
    }

}
