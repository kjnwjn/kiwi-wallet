<?php
class Logout extends Controller
{
    
    public function __construct()
    {
        if (isset($_COOKIE['JWT_TOKEN'])) {
            unset($_COOKIE['JWT_TOKEN']);
            setcookie('JWT_TOKEN', null, -1, '/');
        }
        header('Location: ' . getenv('BASE_URL'));
        die();
    }
}
