<?php

spl_autoload_register(function ($className) {
    if (file_exists(__DIR__ . '/../src/core/' . $className . '.php')) {
        require_once(__DIR__ . '/../src/core/' . $className . '.php');
    } elseif (file_exists(__DIR__ . '/../src/controllers/' . $className . '.php')) {
        require_once(__DIR__ . '/../src/controllers/' . $className . '.php');
    } elseif (file_exists(__DIR__ . '/../src/models/' . $className . '.php')) {
        require_once(__DIR__ . '/../src/models/' . $className . '.php');
    } elseif (file_exists(__DIR__ . '/../src/views/' . $className . '.php')) {
        require_once(__DIR__ . '/../src/views/' . $className . '.php');
    } else {
        return false;
    }
});
