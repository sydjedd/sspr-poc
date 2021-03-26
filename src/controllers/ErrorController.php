<?php

class ErrorController extends Controller
{
    public static function forbidden()
    {
        ob_end_clean();
        http_response_code(403);
        header('Content-type: text/html;charset=UTF-8');
        $errorNumber = 403;
        $errorText = 'Interdit';
        $css[] = 'message.css';
        require(__DIR__ . '/../../src/views/errorView.php');
        exit();
    }

    public static function notFound()
    {
        ob_end_clean();
        http_response_code(404);
        header('Content-type: text/html;charset=UTF-8');
        $errorNumber = 404;
        $errorText = 'Page non trouvée';
        $css[] = 'message.css';
        require(__DIR__ . '/../../src/views/errorView.php');
        exit();
    }

    public static function methodNotAllowed()
    {
        ob_end_clean();
        http_response_code(405);
        header('Content-type: text/html;charset=UTF-8');
        $errorNumber = 405;
        $errorText = 'Méthode non autorisée';
        $css[] = 'message.css';
        require(__DIR__ . '/../../src/views/errorView.php');
        exit();
    }

    public static function internalServerError($message)
    {
        ob_end_clean();
        http_response_code(500);
        header('Content-type: text/html;charset=UTF-8');
        $errorNumber = 500;
        $errorText = 'Erreur interne du serveur<br />' . $message;
        $css[] = 'message.css';
        require(__DIR__ . '/../../src/views/errorView.php');
        exit();
    }

    public static function applicationError($message)
    {
        ob_end_clean();
        http_response_code();
        header('Content-type: text/html;charset=UTF-8');
        $errorNumber = '';
        $errorText = $message;
        $css[] = 'message.css';
        require(__DIR__ . '/../../src/views/errorView.php');
        exit();
    }
}
