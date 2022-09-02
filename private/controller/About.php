<?php

class About extends Controller
{
    protected $middleware;
    function default()
    {
        $this->view('Layout', array(
            'title' => 'About',
            'page' => 'about'
        ));
    }
}
