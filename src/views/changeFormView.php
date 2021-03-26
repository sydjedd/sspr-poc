<?php ob_start(); ?>
<form method="POST" action="<?= Config::get('APP_DIR') ?>/password/change">
    <h6 class="mdc-typography mdc-typography--headline6">
        INSERM
        <br>
        Modification de votre mot de passe
    </h6>

    <label id="email" class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
        <span class="mdc-notched-outline">
            <span class="mdc-notched-outline__leading"></span>
            <span class="mdc-notched-outline__notch">
                <span class="mdc-floating-label">Courriel</span>
            </span>
            <span class="mdc-notched-outline__trailing"></span>
        </span>
        <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading">account_circle</i>
        <input class="mdc-text-field__input" name="email" type="email" tabindex="1" autocomplete="off" required pattern="^[a-z0-9._%+-]+@(ext\.){0,1}inserm\.fr$">
    </label>
    <div class="mdc-text-field-helper-line">
        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg">Votre courriel doit repecter le format nom.prenom@inserm.fr ou nom.prenom@ext.inserm.fr</div>
    </div>

    <label id="current-password" class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon mdc-text-field--with-trailing-icon">
        <span class="mdc-notched-outline">
            <span class="mdc-notched-outline__leading"></span>
            <span class="mdc-notched-outline__notch">
                <span class="mdc-floating-label">Ancien mot de passe</span>
            </span>
            <span class="mdc-notched-outline__trailing"></span>
        </span>
        <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading">password</i>
        <input class="mdc-text-field__input" name="current-password" type="password" tabindex="2" autocomplete="off" required>
        <i class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing" tabindex="0" role="button">visibility</i>
    </label>
    <div class="mdc-text-field-helper-line">
        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg">Veuillez saisir votre mot de passe</div>
    </div>

    <label id="new-password" class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon mdc-text-field--with-trailing-icon">
        <span class="mdc-notched-outline">
            <span class="mdc-notched-outline__leading"></span>
            <span class="mdc-notched-outline__notch">
                <span class="mdc-floating-label">Nouveau mot de passe</span>
            </span>
            <span class="mdc-notched-outline__trailing"></span>
        </span>
        <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading">password</i>
        <input class="mdc-text-field__input" name="new-password" type="password" tabindex="3" autocomplete="off" required pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9 ]).{12,}">
        <i class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing" tabindex="0" role="button">visibility</i>
    </label>
    <div class="mdc-text-field-helper-line">
        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg" id="new-password-helper-text">Votre nouveau mot de passe doit contenir au moins 12 caractères avec 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial</div>
    </div>

    <label id="re-new-password" class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon mdc-text-field--with-trailing-icon">
        <span class="mdc-notched-outline">
            <span class="mdc-notched-outline__leading"></span>
            <span class="mdc-notched-outline__notch">
                <span class="mdc-floating-label">Confirmez votre nouveau mot de passe</span>
            </span>
            <span class="mdc-notched-outline__trailing"></span>
        </span>
        <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading">password</i>
        <input class="mdc-text-field__input" type="password" tabindex="4" autocomplete="off" required pattern="^mon nouveau mot de passe$">
        <i class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing" tabindex="0" role="button">visibility</i>
    </label>
    <div class="mdc-text-field-helper-line">
        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg">Veuillez confirmer votre nouveau mot de passe</div>
    </div>

    <button id="submit-button" type="button" class="mdc-button mdc-button--raised">
        <span class="mdc-button__ripple"></span>
        <span class="mdc-button__label">Modifier mon mot de passe</span>
    </button>

    <div id="progress-bar" role="progressbar" class="mdc-linear-progress mdc-linear-progress--indeterminate mdc-linear-progress--closed">
        <div class="mdc-linear-progress__buffer">
            <div class="mdc-linear-progress__buffer-dots"></div>
            <div class="mdc-linear-progress__buffer-bar"></div>
        </div>
        <div class="mdc-linear-progress__bar mdc-linear-progress__primary-bar">
            <span class="mdc-linear-progress__bar-inner"></span>
        </div>
        <div class="mdc-linear-progress__bar mdc-linear-progress__secondary-bar">
            <span class="mdc-linear-progress__bar-inner"></span>
        </div>
    </div>
</form>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../../src/views/mainView.php'); ?>
