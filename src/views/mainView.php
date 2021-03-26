<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <meta name="description" content="<?= Config::get('APP_DESCRIPTION') ?>">
    <meta name="author" content="CISAD">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Config::get('APP_NAME') ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= Config::get('APP_DIR') ?>/img/favicon.ico">
    <link rel="stylesheet" href="<?= Config::get('APP_DIR') ?>/css/material-components-web.min.css">
    <link rel="stylesheet" href="<?= Config::get('APP_DIR') ?>/css/main.css">
    <?php
        $css = isset($css) ? $css : [];
        array_walk($css, function ($chaine) {echo '<link rel="stylesheet" href="' . Config::get('APP_DIR') . '/css/' . $chaine . '">';});
    ?>
</head>

<body>
    <?= $content ?>
    
    <script src="<?= Config::get('APP_DIR') ?>/js/material-components-web.min.js"></script>
    <script>var APP_DIR = '<?= Config::get('APP_DIR') ?>';</script>
    <?php
        $js = isset($js) ? $js : [];
        array_unshift($js, 'main.js');
        array_walk($js, function ($chaine) {echo '<script src="' . Config::get('APP_DIR') . '/js/' . $chaine . '"></script>';});
    ?>
</body>

</html>
