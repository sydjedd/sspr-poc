<?php

class ChangeController extends Controller
{
    public static function getForm(array $arguments, array $parameters)
    {
        $css[] = 'changeForm.css';
        $js[] = 'changeForm.js';
        require(__DIR__ . '/../../src/views/changeFormView.php');
    }

    public static function setPassword(array $arguments, array $parameters)
    {
        $message = '';
        $email = $parameters['email'];
        $currentPassword = $parameters['current-password'];
        $newPassword = $parameters['new-password'];

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
        $uid = $user->uid;
        if(!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9 ]).{12,}/', $newPassword)) {
            ErrorController::applicationError('Votre nouveau mot de passe doit contenir au moins 12 caractères avec 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial');
        }
        if(BlueMindModel::auth($email, $currentPassword) === false) {
            ErrorController::applicationError('Veuillez verifier le mot de passe que vous avez saisi');
        }
        if(BlueMindModel::changeUserPassword($uid, $newPassword, $currentPassword) === false) {
            ErrorController::applicationError(BlueMindModel::getError());
        }
        BlueMindModel::close();

        $message = 'Votre mot de passe a été modifié.';
        $css[] = 'message.css';
        require(__DIR__ . '/../../src/views/successView.php');
    }
}
