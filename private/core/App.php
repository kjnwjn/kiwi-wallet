<?php
class App
{
    protected $Controller = "NotFound";
    protected $Action = "default";
    protected $Params = [];

    function __construct()
    {
        $arr = $this->urlProcess();
        if (!$arr) {
            $arr = array('home');
        }
        if (file_exists('./private/controller/' . $arr[0] . '.php')) {
            $this->Controller = $arr[0];
            unset($arr[0]);
        };

        require_once './private/controller/' . $this->Controller . '.php';
        $this->Controller = new $this->Controller;

        // Xử lí url element Action 
        if (isset($arr[1])) {
            if (method_exists($this->Controller, $arr[1])) {
                $this->Action = $arr[1];
            }
            unset($arr[1]);
        }
        // Xử lí url element Params
        $this->Params = $arr ? array_values($arr) : [];
        call_user_func_array([$this->Controller, $this->Action], $this->Params);
    }

    function UrlProcess()
    {
        if (isset($_GET["url"])) {
            return explode("/", filter_var(trim($_GET["url"], "/")));
        }
    }
}
