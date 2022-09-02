<?php
require_once('./private/core/Controller.php');
require_once('./vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class transactionApi extends Controller{
    protected $middleware;

    function __construct($route, $param)
    {
        $this->middleware = new ApiMiddleware();
        $this->middleware->authentication();
        $payload = $this->middleware->jwt_get_payload();
        !($payload) ? 
        $this->middleware->json_send_response(200, array(
            'status' => false,
            "header_status_code" => 200,
            'msg' => 'Please login first!',
            'redirect' => getenv('BASE_URL') . 'login',
        )) : null;
        !($payload->role == 'actived')? 
        $this->middleware->json_send_response(404, array(
            'status' => false,
            "header_status_code" => 404,
            'msg' => 'This account does not have permission!!'
        )) : null;
    
        switch ($route) {
            case 'transaction-histories':
                $this->histories($payload,$param);
                break;
            case 'transaction-detail': 
                $this->middleware->request_method('get');
                $this->transactionDetails($param);
                break;
            case 'phone-card-transaction':
                $this->middleware->request_method('get');
                $this->listPhoneCardbyIdTrans($param);
                break;
            case 'confirm-OTP':
                break;
            default:
                $this->middleware->json_send_response(404, array(
                    'status' => false,
                    "header_status_code" => 404,
                    'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
                ));
        }

    }

    function histories($payload,$param){
        $allTrans = $this->model('Transaction')->SELECT_ORDER_BY_DESC('email',$payload->email,'createdAt') ;
        !$allTrans ?$this->middleware->json_send_response(200, array(
            'status' => false,
            "header_status_code" => 200,
            'msg' => 'Does not have any translations!',
        )) : null;
       
        switch ($param) {
            case 'recharge':
                $transRecharge = [];
                foreach ($allTrans as $key => $value) {
                    if ($value['type_transaction'] == '1') {
                        array_push($transRecharge, $allTrans[$key]);
                    }
                }
                !$transRecharge ? $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'header_status_code' => 200,
                    'msg' => 'Do not have any transaction !',
                )) : $this->middleware->json_send_response(200, array(
                    'status' => true,
                    "header_status_code" => 200,
                    'msg' => 'Load List User successfully!',
                    'data' => $transRecharge,
                ));
                break;

            case 'transfer':
                $transTransfer = [];
                foreach ($allTrans as $key => $value) {
                    if ($value['type_transaction'] == '2') {
                        array_push($transTransfer, $allTrans[$key]);
                    }
                }
                !$transTransfer ? $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'header_status_code' => 200,
                    'msg' => 'Do not have any transaction !',
                )) : $this->middleware->json_send_response(200, array(
                    'status' => true,
                    "header_status_code" => 200,
                    'msg' => 'Load List User successfully!',
                    'data' => $transTransfer,
                ));
                break;

            case 'withdraw':
                $transWithdraw = [];
                foreach ($allTrans as $key => $value) {
                    if ($value['type_transaction'] == '3') {
                        array_push($transWithdraw, $allTrans[$key]);
                    }
                }
                !$transWithdraw ? $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'header_status_code' => 200,
                    'msg' => 'Do not have any transaction !',
                )) : $this->middleware->json_send_response(200, array(
                    'status' => true,
                    "header_status_code" => 200,
                    'msg' => 'Load List User successfully!',
                    'data' => $transWithdraw,
                ));
                print_r($transWithdraw);
                break;
            case 'phonecard':
                $transPhonecard = [];
                foreach ($allTrans as $key => $value) {
                    if ($value['type_transaction'] == '4') {
                        array_push($transPhonecard, $allTrans[$key]);
                    }
                }
                !$transPhonecard ? $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'header_status_code' => 200,
                    'msg' => 'Do not have any transaction !',
                )) : $this->middleware->json_send_response(200, array(
                    'status' => true,
                    "header_status_code" => 200,
                    'msg' => 'Load List User successfully!',
                    'data' => $transPhonecard,
                ));
                print_r($transPhonecard);
                break;
            
            case '':
                !$allTrans ? $this->middleware->json_send_response(200, array(
                    'status' => false,
                    'header_status_code' => 200,
                    'msg' => 'Do not have any transaction !',
                )) : $this->middleware->json_send_response(200, array(
                    'status' => true,
                    "header_status_code" => 200,
                    'msg' => 'Load List Transaction successfully!',
                    'data' => $allTrans,
                ));
                break;
            default:
                $this->middleware->json_send_response(404, array(
                    'status' => false,
                    "header_status_code" => 404,
                    'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
                ));
        }
    }

    function transactionDetails($transaction_id)
    {
        !$transaction_id ? $this->middleware->json_send_response(404, array(
            'status' => false,
            "header_status_code" => 404,
            'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
        )) : null;

        $transaction = $this->model('transaction')->SELECT_ONE('transaction_id', $transaction_id);
        !$transaction ? $this->middleware->json_send_response(200, 'This transaction does not exist') :
            $this->middleware->json_send_response(200, array(
                'status' => true,
                "header_status_code" => 200,
                'msg' => 'Load transaction successfully!',
                'data' => $transaction,
            ));
    }
    function listPhoneCardbyIdTrans($transaction_id){
        !$transaction_id ? $this->middleware->json_send_response(404, array(
            'status' => false,
            "header_status_code" => 404,
            'msg' => 'This endpoint cannot be found, please contact adminstrator for more information!'
        )) : null;

        $listPhoneCard = $this->model('phoneCard')->SELECT('transaction_id', $transaction_id);
        !$listPhoneCard ? $this->middleware->json_send_response(200, 'This transaction does not have any phone card') :
            $this->middleware->json_send_response(200, array(
                'status' => true,
                "header_status_code" => 200,
                'msg' => 'Load User successfully!',
                'data' => $listPhoneCard,
            ));
    }
}
    