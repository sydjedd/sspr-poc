<?php
// TODO revoir les routes en vue d une API REST et bien distinguer les routes pour les vues
// On utilise des action dans l url au lieu de methode GET POST PUT PATCH DELETE
return [
    'APP_ROUTES' => [
        ['/^\/log$/i', 'GET', 'User', 'log', 'national'], // Log

        ['/^\/password\/change$/i', 'GET', 'Change', 'getForm', 'all'], // Changement du mot de passe formulaire
        ['/^\/password\/change$/i', 'POST', 'Change', 'setPassword', 'all'], // Changement du mot de passe

        ['/^\/password\/recovery$/i', 'GET', 'Recovery', 'getEmailForm', 'all'], // Réinitialisation du mot de passe formulaire
        ['/^\/password\/recovery$/i', 'POST', 'Recovery', 'setRecoveryToken', 'all'], // Réinitialisation du mot de passe envoi token
        ['/^\/password\/recovery\/([0-9a-zA-Z]+)$/i', 'GET', 'Recovery', 'getRecoveryForm', 'all'], // Réinitialisation du mot de passe envoi token
        ['/^\/password\/recovery\/([0-9a-zA-Z]+)$/i', 'POST', 'Recovery', 'setPassword', 'all'], // Réinitialisation du mot de passe envoi token

        ['/^\/login$/i', 'GET', 'User', 'getLoginForm', 'all'], // En construction

        ['/^\/.*$/i', 'GET', 'Default', 'get', 'all'], // Page d accueil
    ]
];
