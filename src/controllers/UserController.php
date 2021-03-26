<?php

class UserController extends Controller
{
    public static function getLoginForm(array $arguments, array $parameters)
    {
        $message = 'En construction';
        $css[] = 'message.css';
        require(__DIR__ . '/../../src/views/successView.php');
    }
}
