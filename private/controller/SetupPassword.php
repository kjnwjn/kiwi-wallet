<?php
require_once('./vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class SetupPassword extends Controller
{
    function __construct()
    {
        $this->middleware = new ApiMiddleware();
        $payload = $this->middleware->jwt_get_payload();
        $userInfor = $this->model('Account')->SELECT_ONE('phoneNumber',$payload->phoneNumber);
      
        if($userInfor['initialPassword'] == null) {   
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
            'title' => 'Setup Password',
            'page' => 'setupPassword'
        ));
    }
}
