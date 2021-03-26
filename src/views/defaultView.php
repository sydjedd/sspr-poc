<?php ob_start(); ?>
<h6 class="mdc-typography mdc-typography--headline6 headline">
    INSERM
</h6>

<a class="mdc-button mdc-button--raised" href="<?= Config::get('APP_DIR') ?>/password/change">
    <span class="mdc-button__ripple"></span>
    <span class="mdc-button__label">Modifier votre mot de passe</span>
</a>

<a class="mdc-button mdc-button--raised" href="<?= Config::get('APP_DIR') ?>/password/recovery">
    <span class="mdc-button__ripple"></span>
    <span class="mdc-button__label"></span>Réinitialiser votre mot de passe</span>
</a>

<a class="mdc-button mdc-button--raised" href="<?= Config::get('APP_DIR') ?>/login">
    <span class="mdc-button__ripple"></span>
    <span class="mdc-button__label"></span>Consulter vos données</span>
</a>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../../src/views/mainView.php'); ?>
