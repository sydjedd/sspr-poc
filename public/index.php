<?php
// TODO Optimiser les tables avec index et recherche plain text
// TODO Ameliorer le htaccess
// TODO Factoriser le CSS et suppression du CSS inutilisé
// TODO Creer une class App pour gerer toute l'application
// TODO Injection de dependance dans le core du MVC
// TODO Utiliser les namespaces
require(__DIR__ . '/../config/autoload.php');

Config::init();
Errors::init();
Session::init();
Http::init();
//Database::init();
Router::init();
Router::addRoutes(Config::get('APP_ROUTES'));

$matchedRoute = Router::matchedRoute();
$controllerClassName = $matchedRoute['controller'] . 'Controller';
$controllerMethod = $matchedRoute['controllerMethod'];
$controllerClassName::$controllerMethod(Http::$arguments, Http::$parameters);
