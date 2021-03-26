<?php

class RecoveryController extends Controller
{
    public static function getEmailForm(array $arguments, array $parameters)
    {
        $css[] = 'emailForm.css';
        $js[] = 'emailForm.js';
        require(__DIR__ . '/../../src/views/emailFormView.php');
    }

    public static function getRecoveryForm(array $arguments, array $parameters)
    {
        $token = $arguments[0];
        if(static::isValidToken($token) === false) { return false; }
        $css[] = 'recoveryForm.css';
        $js[] = 'recoveryForm.js';
        require(__DIR__ . '/../../src/views/recoveryFormView.php');
    }

    public static function setRecoveryToken(array $arguments, array $parameters)
    {
        $user =  null;
        $email = $parameters['email'];

        if(BlueMindModel::init(Config::get('BM_HOST'), Config::get('BM_LOGIN'), Config::get('BM_PASSWORD')) === false) {
            ErrorController::applicationError(BlueMindModel::getError());
        }
        if(!preg_match('/^[a-z0-9._%+-]+@(ext\.){0,1}inserm\.fr$/', $email)) {
            ErrorController::applicationError('Votre courriel doit repecter le format nom.prenom@inserm.fr ou nom.prenom@ext.inserm.fr');
        }
        $user = BlueMindModel::getUserByEmail($email);
        if($user === null) {
            ErrorController::applicationError('Aucun compte ne correspond au courriel que vous avez saisi');
        }
        $user = UserModel::getByEmail($email);
        if($user === null) {
            ErrorController::applicationError('Vous n\'avez pas renseigné de courriel de secours');
        }
        $emailRecovery = $user[1];
        $token = UserModel::setToken($email);
        if($token === null) {
            ErrorController::applicationError('Une erreur est survenue lors de la création du jeton');
        }
        $subject = 'Réinitialisez votre mot de passe';
        $message =
            'Bonjour,' . "\r\n" .
            "\r\n" .
            'Cliquez sur ce lien valide pendant 24h pour changez votre mot de passe :' . "\r\n" .
            Config::get('APP_URL') . Config::get('APP_DIR') . '/password/recovery/' . $token
        ;
        $headers =
            'From: sspr-poc@inserm.fr' . "\r\n" .
            'Reply-To: no-reply@inserm.fr' . "\r\n"
        ;
        if(mail($emailRecovery, $subject, $message, $headers) === false) {
            ErrorController::applicationError('Une erreur est survenue lors de l\'envoie du courriel de réinitialisation');
        }
        $positionAt = strpos($emailRecovery, '@');
        $positionDot = strrpos($emailRecovery, '.');
        $emailAnonymized = str_pad(substr($emailRecovery, 0, 1), $positionAt, '*') . '@' . str_pad(substr($emailRecovery, $positionAt + 1, 1), $positionDot - 1 - $positionAt, '*') . substr($emailRecovery, $positionDot);
        $message = 'Un courriel avec un lien valide 24h vous à été envoyé à l\'adresse ' . $emailAnonymized . ' pour réinitialisez votre mot de passe.';
        $css[] = 'message.css';
        require(__DIR__ . '/../../src/views/successView.php');
        return true;
    }

    public static function setPassword(array $arguments, array $parameters)
    {
        $token = $arguments[0];
        $newPassword = $parameters['new-password'];
        if(static::isValidToken($token) === false) { return false; }
        $user = UserModel::getByToken($token);
        $email = $user[0];
        if(BlueMindModel::init(Config::get('BM_HOST'), Config::get('BM_LOGIN'), Config::get('BM_PASSWORD')) === false) {
            ErrorController::applicationError(BlueMindModel::getError());
        }
        $user = BlueMindModel::getUserByEmail($email);
        if($user === null) {
            ErrorController::applicationError('Aucun compte ne correspond au courriel que vous avez saisi');
        }
        $uid = $user->uid;
        if(!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9 ]).{12,}/', $newPassword)) {
            ErrorController::applicationError('Votre nouveau mot de passe doit contenir au moins 12 caractères avec 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial');
        }
        if(BlueMindModel::changeUserPassword($uid, $newPassword) === false) {
            ErrorController::applicationError(BlueMindModel::getError());
        }
        UserModel::removeToken($email);
        BlueMindModel::close();
        $message = 'Votre mot de passe a été modifié.';
        $css[] = 'message.css';
        require(__DIR__ . '/../../src/views/successView.php');
    }

    public static function isValidToken(string $token): bool
    {
        $user = UserModel::getByToken($token);
        if($user === null) {
            ErrorController::applicationError('Cette demande de réinitialisation de mot de passe n\'existe pas');
        }
        $dateExpirationToken = new DateTime($user[3], new DateTimeZone('Europe/Paris'));
        $dateNow = new DateTime('NOW', new DateTimeZone('Europe/Paris'));
        if($dateExpirationToken < $dateNow) {
            ErrorController::applicationError('Votre demande de réinitialisation de mot de passe a expirée');
        }
        return true;
    }
}
