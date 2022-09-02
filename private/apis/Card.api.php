<?php

require_once('./private/core/Controller.php');
require_once('./vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class CardApi extends Controller
{
    protected $middleware;

    function __construct($route, $param)
    {
        $this->middleware = new ApiMiddleware();
        switch ($route) {
            case 'query':
                $this->middleware->request_method('get');
                $this->middleware->authentication();
                $this->query($param);
                break;
            default:
                $this->middleware->json_send_response(404, array(
                    'status' => false,
                    "header_status_code" => 404,
                    'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
                ));
        }
    }

    function query($param)
    {
        (empty($param)) ?
            $this->middleware->json_send_response(200, array(
                'status' => false,
                'msg' => 'Card id is missing...'
            )) : null;

        $cardFound = $this->model('Card')->SELECT_ONE('card_id', $param);
        !$cardFound ? $this->middleware->json_send_response(200, array(
            'status' => false,
            'msg' => 'Failed to query! Card id is invalid!'
        )) : null;

        $this->middleware->json_send_response(200, array(
            'status' => true,
            'msg' => 'Successfully!',
            'data' => $cardFound
        ));
    }
}
