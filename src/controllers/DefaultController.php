<?php

class DefaultController extends Controller
{
    public static function get(array $arguments, array $parameters)
    {
        $css[] = 'default.css';
        require(__DIR__ . '/../../src/views/defaultView.php');
    }
}
