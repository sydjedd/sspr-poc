<?php
// TODO Faire une class error ou exception et inclure toutes ces fonctions

final class Errors
{
    final public static function init()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        ini_set('error_reporting', E_ALL);
        set_error_handler('Errors::error');
        set_exception_handler('Errors::erreurException');
        register_shutdown_function('Errors::erreurArret');
    }

    final public static function error($numero, $message, $fichier = '', $ligne = '')
    {
        $resultatHTML = '';

        $erreurLibelle = array (
            E_ERROR				=> 'Erreur',
            E_WARNING			=> 'Alerte',
            E_PARSE				=> 'Erreur de syntaxe',
            E_NOTICE			=> 'Remarque',
            E_DEPRECATED        => 'Code déprécié',
            E_CORE_ERROR		=> 'Erreur de code',
            E_CORE_WARNING		=> 'Alerte de code',
            E_COMPILE_ERROR		=> 'Erreur de moteur',
            E_COMPILE_WARNING	=> 'Alerte de moteur',
            E_USER_ERROR		=> 'Erreur utilisateur',
            E_USER_WARNING		=> 'Alerte utilisateur',
            E_USER_NOTICE		=> 'Remarque utilisateur',
            E_USER_DEPRECATED   => 'Code déprécié utilisateur',
            E_STRICT			=> 'Suggestion d\'amélioration',
            E_RECOVERABLE_ERROR => 'Erreur récupérable',
            'E_EXCEPTION'		=> 'Exception',
            'E_MYSQL'           => 'Erreur MySQL',
            'E_LDAP'            => 'Erreur LDAP',
            'E_APPLICATION'     => 'Erreur Applicative'
        );

        if($numero === E_WARNING && false !== stripos($message, 'ldap_bind')) {
            self::error('E_LDAP', 'Identifiant ou mot de passe incorrect dans l\'AD');
        } else if($numero === 'E_APPLICATION' || $numero === 'E_LDAP') {
            $resultatHTML = $message;
        } else {
            if (Config::get('APP_ENV') === 'development') {
                fwrite($fichierErreurs, date('d.m.Y H:i:s').';'.$erreurLibelle[$numero].';'.$message.';'.basename($fichier).';'.$ligne."\r\n");
                fclose($fichierErreurs);
                $fichier = explode('/', $fichier);
                $fichier = array_pop($fichier);
                $resultatHTML = $message.'<br />Dans dans le fichier '.basename($fichier).' à la ligne '.$ligne;
            } else {
                $resultatHTML = 'Une erreur s\'est produite<br />Veuillez contacter un administrateur.';
                if (is_file('./app.log')) {
                    $fichierErreurs = fopen('./app.log', 'a');
                } else {
                    $fichierErreurs = fopen('./app.log', 'x');
                }
            }
        }

        ErrorController::internalServerError($resultatHTML);
    }

    final public static function erreurException($exception)
    {
        self::error('E_EXCEPTION', $exception->getMessage(), $exception->getFile(), $exception->getLine());
    }


    final public static function  erreurArret()
    {
	    $erreur = error_get_last();

        if($erreur && $erreur['type']) {
            self::error($erreur['type'], $erreur['message'], $erreur['file'], $erreur['line']);
        }
        exit();
    }


    final public static function  erreurRequete($connexion)
    {
        $debug   = debug_backtrace();
        $debug   = $debug[0];
        $fichier = basename($debug['file']);
        $ligne   = $debug['line'];
        self::error('E_MYSQL', mysqli_error($connexion), $fichier, $ligne);
    }
}
