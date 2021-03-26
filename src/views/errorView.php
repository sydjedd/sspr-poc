<?php ob_start(); ?>
    <h6 class="mdc-typography mdc-typography--headline6 headline">
        INSERM
    </h6>

    <div class="mdc-typography mdc-typography--overline error"><?= $errorNumber . ' ' . $errorText ?></div>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../../src/views/mainView.php'); ?>
