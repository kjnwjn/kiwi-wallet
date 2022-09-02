<?php

class News extends Controller
{
    function default()
    {
        $this->view('Layout', array(
            'title' => 'News',
            'page' => 'news'
        ));
    }
}
