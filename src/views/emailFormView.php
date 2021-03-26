<?php ob_start(); ?>
<form method="POST" action="<?= Config::get('APP_DIR') ?>/password/recovery">
    <h6 class="mdc-typography mdc-typography--headline6 headline">
        INSERM
        <br>
        Demande de réinitialisation de votre mot de passe
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
