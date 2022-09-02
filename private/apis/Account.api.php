<?php

require_once('./vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AccountApi extends Controller
{
    protected $middleware;

    function __construct($route, $param)
    {
        $this->middleware = new ApiMiddleware();
        switch ($route) {
            case 'login':
                $this->middleware->request_method('post');
                $payload = $this->middleware->jwt_get_payload();
                !$payload ? $this->login() : $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'msg' => 'You logged in before.',
                    'redirect' => getenv('BASE_URL'),
                ));
                break;
            case 'register':
                $this->middleware->request_method('post');
                $this->register();
                break;
            case 'setup-password':
                $this->middleware->request_method('post');
                $this->middleware->authentication();
                $payload = $this->middleware->jwt_get_payload();
                $userPayload = $this->model('Account')->SELECT_ONE('email', $payload->email);
                if ($userPayload['initialPassword'] === 'NULL') {
                    $this->middleware->json_send_response(200, array(
                        'status' => false,
                        'msg' => 'Your account cannot access this endpoint.',
                        'redirect' => getenv('BASE_URL')
                    ));
                }
                $this->setupPassword();
                break;
            case 'create-hashed':
                $this->middleware->request_method('post');
                $this->middleware->authentication();
                $this->createHashed();
                break;
            case 'hashed-verify':
                $this->middleware->request_method('post');
                $this->middleware->authentication();
                $this->hashedVerify();
                break;
            case 'profile':
                $this->middleware->authentication();
                $payload = $this->middleware->jwt_get_payload();
                $this->userProfile($payload);
                break;
            case 'change-password':
                $this->middleware->request_method('post');
                $this->middleware->authentication();
                $payload = $this->middleware->jwt_get_payload();
                $this->changePassword($payload);
                break;
            case 'user-details':
                $this->middleware->request_method('get');
                $this->middleware->authentication();
                $this->userDetails($param);
                break;
            case 'upload-image':
                $this->middleware->request_method('post');
                $this->middleware->authentication();
                $payload = $this->middleware->jwt_get_payload();
                $this->uploadImage($payload);
                break;
            default:
                $this->middleware->json_send_response(404, array(
                    'status' => false,
                    "header_status_code" => 404,
                    'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
                ));
        }
    }

    function createHashed()
    {
        $bodyDataErr = $this->utils()->validateBody(($_POST), array(
            'string' => array(
                'required' => true,
                'min' => 6,
            ),
        ));
        $bodyDataErr ? $this->middleware->error_handler(200, $bodyDataErr) : null;
        $hashed = password_hash($_POST['string'], PASSWORD_DEFAULT);
        $this->middleware->json_send_response(200, array(
            'status' => true,
            'origin' => $_POST['string'],
            'hashed' => $hashed,
        ));
    }

    function hashedVerify()
    {
        $bodyDataErr = $this->utils()->validateBody(($_POST), array(
            'origin' => array(
                'required' => true,
                'min' => 6,
            ),
            'hashed' => array(
                'required' => true,
                'min' => 6,
            ),
        ));
        $bodyDataErr ? $this->middleware->error_handler(200, $bodyDataErr) : null;
        $hashed = password_verify($_POST['origin'], $_POST['hashed']);
        $this->middleware->json_send_response(200, array(
            'status' => $hashed ? true : false,
            'origin' => $_POST['origin'],
            'hashed' => $_POST['hashed'],
            'verify_status' => $hashed ? 'success' : 'failed',
        ));
    }

    function login()
    {
        // print_r($_POST);
        if(isset($_POST['phoneNumber']) && trim($_POST['phoneNumber'] == 'admin')){
            if(isset($_POST['password']) && trim($_POST['password']) =='123456'){
                $jwt = JWT::encode(array(
                    'email' => 'admin@gmail.com',
                    'phoneNumber' => 'admin',
                    'fullname' => 'admin',
                    'role' => 'admin',
                ), getenv('SECRET_KEY'), 'HS256');
    
                // Set client cookie
                setcookie('JWT_TOKEN', $jwt, time() + (86400 * 1), "/"); /* 86400 = 1 day */
                if($_POST['phoneNumber'])
                $this->middleware->json_send_response(200, array(
                    'status' => true,
                    'msg' => 'Login successfully, redirecting...',
                    'redirect' => getenv('BASE_URL') . 'Dashboard',
                ));
            }
        }
        // Validation body data
        $bodyDataErr = $this->utils()->validateBody(($_POST), array(
            'phoneNumber' => array(
                'required' => true,
                'tel' => true,
            ),
            'password' => array(
                'required' => true,
                'min' => 6,
            ),
        ));

        // Handle error if exist
        $bodyDataErr ? $this->middleware->error_handler(200, $bodyDataErr) : null;

        // Check account is exist or not
        $userFound = $this->model('Account')->SELECT_ONE('phoneNumber', $_POST['phoneNumber']);
        !$userFound ? $this->middleware->error_handler(404, 'This account does not exist!') : null;

        // Check account blocked
        $userFound['role'] == 'blocked'
        ? $this->middleware->error_handler(200, 'Your account has been unactivated, please contact adminstrator for more information.')
        : null;

        // Check account disable
        $userFound['role'] == 'disabled' 
        ? $this->middleware->error_handler(200, 'Your account has been disable, please contact adminstrator for more information.'): null;
        // Check clocked in 1 minute
        (isset($_SESSION['a_minute_expire']) && time() < $_SESSION['a_minute_expire']) ?
            $this->middleware->json_send_response(200, array(
                'status' => false,
                'header_status_code' => 200,
                'msg' => 'Your account has been unactivated in 1 minute',
                'expired' => $_SESSION['a_minute_expire']
            )) : null;

        // Check account password
        $correctPassword = $userFound['initialPassword'] !== 'NULL' ?
            password_verify($_POST['password'], $userFound['initialPassword']) :
            password_verify($_POST['password'], $userFound['password']);

        // If wrong password
        if (!$correctPassword) {

            // Number of wrong password count
            $wrongPassCount =  $userFound['wrongPassCount'] + 1;

            // Increase wrongPassCount up 1
            $this->model('Account')->UPDATE_ONE(array('phoneNumber' => $_POST['phoneNumber']), array(
                'wrongPassCount' => $wrongPassCount
            ));

            // Unactivated account in 1 minute if wrong password in 3 times
            if ($wrongPassCount  == 3) {
                $_SESSION['a_minute_expire'] = time() + 60;
                $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'header_status_code' => 200,
                    'msg' => 'Your account has been unactivated in 1 minute',
                    'expired' => $_SESSION['a_minute_expire']
                ));
            }else if ($wrongPassCount == 6) {
                $this->model('Account')->UPDATE_ONE(array('phoneNumber' => $_POST['phoneNumber']), array('role' => 'blocked'));
                $this->middleware->error_handler(200, 'Your account has been unactivated, please contact adminstrator for more information.');
            }else{

                $this->middleware->error_handler(200, 'Password is incorrect!');
            }

            // Unactivated account if wrong password many time (>= 6 times)
            

            // Send response
        }

        // Login successfully
        else {

            // Assign a basic jwt token for login success
            $jwt = JWT::encode(array(
                'email' => $userFound['email'],
                'phoneNumber' => $userFound['phoneNumber'],
                'fullname' => $userFound['fullname'],
                'role' => $userFound['role'],
                
            ), getenv('SECRET_KEY'), 'HS256');

            // Update wrong password count to zero
            $this->model('Account')->UPDATE_ONE(array('phoneNumber' => $_POST['phoneNumber']), array(
                'wrongPassCount' => 0
            ));

            // Set client cookie
            setcookie('JWT_TOKEN', $jwt, time() + (86400 * 1), "/"); /* 86400 = 1 day */
            if($_POST['phoneNumber'])

            ($userFound['initialPassword'] !== 'NULL')
            ? $redirect = getenv('BASE_URL') . 'setupPassword'
            : $redirect = getenv('BASE_URL') ;
            
            // Send response
            $this->middleware->json_send_response(200, array(
                'status' => true,
                'msg' => 'Login successfully, redirecting...',
                'redirect' => $redirect,
            ));
        }
    }

    function register()
    {
        // Validation body data
        $bodyDataErr = $this->utils()->validateBody(($_POST), array(
            'email' => array(
                'required' => true,
                'is_email' => true,
            ),
            'phoneNumber' => array(
                'required' => true,
                'tel' => true,
            ),
            'fullname' => array(
                'required' => true,
                'min' => 10,
            ),
            'gender' => array(
                'required' => true,
                'gender' => true,
            ),
            'address' => array(
                'required' => true,
                'min' => 10,
            ),
            'birthday' => array(
                'required' => true,
                'date' => true,
            ),
        ));

        // Validation files data
        // $filesDataErr = $this->utils()->validateFiles(($_FILES), array(
        //     'idCard_front' => array(
        //         'required' => true,
        //         'image' => true,
        //         'size' => 1, /* Maximum size in MB */
        //     ),
        //     'idCard_back' => array(
        //         'required' => true,
        //         'image' => true,
        //         'size' => 1, /* Maximum size in MB */
        //     ),
        // ));

        // Handle error if occur
        $bodyDataErr ? $this->middleware->error_handler(200, $bodyDataErr) : null;
        // $filesDataErr ? $this->middleware->error_handler(200, $filesDataErr) : null;
        $emailFound =  $this->model('Account')->SELECT_ONE('email', $_POST['email']);
        $phoneNumberFound =  $this->model('Account')->SELECT_ONE('phoneNumber', $_POST['phoneNumber']);

        // Check account exist
        $emailFound ? $this->middleware->error_handler(200, 'This email was used by another account!') : null;
        $phoneNumberFound ? $this->middleware->error_handler(200, 'This phone number was used by another account!') : null;

        // Initial files
        // $FILES = $this->utils()->handleUpload($_FILES, ['idCard_front', 'idCard_back']);

        // Start to send an email
        $initialPassword = $this->utils()->generateRandomString();
        
        $sendMailStatus = $this->utils()->sendMail(array(
            "email" => $_POST['email'],
            'title' => 'Acount detail for KiWi App',
            'content' => '
                <body>
                    <p>Thank you for your registering on our application! 
                    Now you can login to your account via follow information below:</p>
                    <p><strong>Phone number: ' . $_POST['phoneNumber'] . '</strong></p>
                    <p><strong>Password: ' . $initialPassword . '</strong></p>
                </body>
            ',
        ));

        // Start to insert to database
        $inserted = $this->model('Account')->INSERT(array(
            'email' => $_POST['email'],
            'phoneNumber' => $_POST['phoneNumber'],
            'fullname' => $_POST['fullname'],
            'gender' => $_POST['gender'],
            'address' => $_POST['address'],
            'birthday' => $_POST['birthday'],
            'initialPassword' => password_hash($initialPassword, PASSWORD_DEFAULT),
            'createdAt' => time(),
            'updatedAt' => time(),
        ));
        !$inserted ? 
        $this->middleware->json_send_response(500, array(
            'status' => false,
            'header_status_code' => 500,
            'debug' => 'Account API function register',
            'msg' => 'An error occurred while processing, please try again!',
            // 'data' => $inserted
        )) : null;
        // 'idCard_front' => $FILES['idCard_front']['path'],
        // 'idCard_back' => $FILES['idCard_back']['path'],

        // Return response to endpoint
        // 
        if ($sendMailStatus && $inserted) {
            $this->middleware->json_send_response(200, array(
                'status' => true,
                'header_status_code' => 200,
                'msg' => 'Register account successfully! We have sent an email that contain your information to login, check it now!',
                'redirect' => getenv('BASE_URL') . 'login'
            ));
        } else {
            $this->middleware->json_send_response(500, array(
                'status' => false,
                'header_status_code' => 500,
                'debug' => 'Account API function register',
                'msg' => 'An error occurred while processing, please try again!'
            ));
        }
    }

    function setupPassword()
    {
        $payload = $this->middleware->jwt_get_payload();
        $userPayload = $this->model('Account')->SELECT_ONE('email', $payload->email);

        // Validation body data
        $bodyDataErr = $this->utils()->validateBody(($_POST), array(
            'password' => array(
                'required' => true,
                'min' => 6,
            ),
            'confirm_password' => array(
                'required' => true,
                'min' => 6,
            ),
        ));

        // Handle body data error
        $bodyDataErr ? $this->middleware->error_handler(200, $bodyDataErr) : null;

        // Check password match
        ($_POST['password'] !== $_POST['confirm_password']) ?
            $this->middleware->json_send_response(200, array(
                'status' => false,
                'msg' => 'Password does not match!',
            )) : null;

        // Update password
        $phoneNumber = $payload->phoneNumber;
        $this->model('Account')->UPDATE_ONE(array('phoneNumber' => $phoneNumber), array('initialPassword' => 'NULL'));
        $this->model('Account')->UPDATE_ONE(array('phoneNumber' => $phoneNumber), array(
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ));

        // Remove cookie
        unset($_COOKIE['JWT_TOKEN']);
        setcookie('JWT_TOKEN', null, -1, '/');

        // Set new cookie
        $jwt = JWT::encode(array(
            'email' =>  $userPayload['email'],
            'phoneNumber' => $userPayload['phoneNumber'],
            'fullname' => $userPayload['fullname'],
            'role' =>  $userPayload['role'],
        ), getenv('SECRET_KEY'), 'HS256');
        setcookie('JWT_TOKEN', $jwt, time() + (86400 * 1), "/"); /* 86400 = 1 day */

        // Send response
        $this->middleware->json_send_response(200, array(
            'status' => true,
            'msg' => 'Your account has been setup password successfully!',
            'redirect' => getenv('BASE_URL')
        ));
    }

    function userProfile($payload){
        $userInfor = $this->model('Account')->SELECT_ONE('email',$payload->email);
        try{
            $this->middleware->json_send_response(200, array(
                'status' => true,
                'msg' => 'Get user information successfully!',
                'response' => array(
                    'email' =>  $userInfor['email'],
                    'phoneNumber' => $userInfor['phoneNumber'],
                    'gender' => $userInfor['gender'],
                    'fullname' => $userInfor['fullname'],
                    'address' => $userInfor['address'],
                    'birthday' => $userInfor['birthday'],
                    'idCard_back' => $userInfor['idCard_back'],
                    'idCard_front' => $userInfor['idCard_front'],
                    'wallet' => $userInfor['wallet'],
                    'role' => $userInfor['role']
                )
            ));
        }catch(Exception $e){
            $this->middleware->error_handler();
        }
    }

    function userDetails($param){
        $payload = $this->middleware->jwt_get_payload();
        $userDetails = !$param ? $this->middleware->error_handler(200,'Phone Number is required!') 
        : $this->model('account')->SELECT_ONE('phoneNumber',$param);
        ($userDetails && ($userDetails['phoneNumber'] != $payload->phoneNumber)) ? $this->middleware->json_send_response(200, array(
            'status' => true,
            'msg' => 'Get user information successfully!',
            'response' => array(
                'email' =>  $userDetails['email'],
                'phoneNumber' => $userDetails['phoneNumber'],
                'fullname' => $userDetails['fullname'],
                'gender' => $userDetails['gender'],
                'address' => $userDetails['address'],
                'birthday' => $userDetails['birthday'],
                'idCard_back' => $userDetails['idCard_back'],
                'idCard_front' => $userDetails['idCard_front'],
                'wallet' => $userDetails['wallet']
            )
        )) :  $this->middleware->json_send_response(200, array(
            'status' => false,
            'msg' => 'user does not exist!',));
           

    }

    function changePassword($payload){

        $bodyDataErr = $this->utils()->validateBody(($_POST), array(
            'oldPassword' => array(
                'required' => true,
                'min' => 6,
            ),
            'newPassword' => array(
                'required' => true,
                'min' => 6,
            ), 
            'confirmPassword' => array(
                'required' => true,
                'min' => 6,
                'match' => 'newPassword'
            ),
        ));
        $bodyDataErr ? $this->middleware->error_handler(200, $bodyDataErr) : null;
        
        $userInfor = $this->model('Account')->SELECT_ONE('email', $payload->email);
        if(password_verify($_POST['oldPassword'], $userInfor['password'])){

            $isSuccess = $this->model('Account')->UPDATE_ONE(array('email' => $userInfor['email']), array('password' => password_hash($_POST['newPassword'],PASSWORD_DEFAULT))) ;
            !$isSuccess ? $this->middleware->error_handler() 
            : $this->middleware->json_send_response(200, array(
                'status' => true,
                'msg' => 'Update password successfully!',
                'redirect' => getenv('BASE_URL')
                )
            );
        }else{
            $this->middleware->json_send_response(200, array(
                'status' => false,
                'msg' => 'Old password incorrect!',
                )
            );
        }
    }

    function uploadImage($payload){
        

        // Validation files data
        $filesDataErr = $this->utils()->validateFiles(($_FILES), array(
            'idCard_front' => array(
                'required' => true,
                'image' => true,
                'size' => 1, /* Maximum size in MB */
            ),
            'idCard_back' => array(
                'required' => true,
                'image' => true,
                'size' => 1, /* Maximum size in MB */
            ),
        ));

        // Handle error if occur
        $filesDataErr ? $this->middleware->error_handler(200, $filesDataErr) : null;
        // Initial files
        $FILES = $this->utils()->handleUpload($_FILES, ['idCard_front', 'idCard_back']);

        // Start to update to database
        $updated = $this->model('Account')->UPDATE_IMAGE(array('email' => $payload->email),array(
            'idCard_front' => $FILES['idCard_front']['path'],
            'idCard_back' => $FILES['idCard_back']['path'],
        ));

        // Return response to endpoint
        // 
        if ($updated) {
            $this->middleware->json_send_response(200, array(
                'status' => true,
                'header_status_code' => 200,
                'msg' => 'Update image successfully! Please wait for administrator confirm your account',
            ));
        } else {
            $this->middleware->json_send_response(500, array(
                'status' => false,
                'header_status_code' => 500,
                'debug' => 'Account API function register',
                'msg' => 'An error occurred while processing, please try again!'
            ));
        }
    }
}
