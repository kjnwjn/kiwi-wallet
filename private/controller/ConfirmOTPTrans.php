<?php
require_once('./vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');
class ConfirmOtpTrans extends Controller
{
    function __construct()
    {
        $this->middleware = new ApiMiddleware();
        $payload = $this->middleware->jwt_get_payload();
        if(!$payload) {   
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
        $this->view('layoutValidate', array(
            'title' => 'Confirm Otp',
            'page' => 'ConfirmOtpTrans'
        ));
    }
}
