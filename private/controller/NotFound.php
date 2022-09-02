<?php

class NotFound extends Controller
{
    function default()
    {
        
        http_response_code(404);
        $this->view('Layout', array(
            'title' => '404 Not Found',
            'page' => '404'
        ));
    }
}
