<?php

function Myautoload($class)
{
    $class = str_replace("\\", "/", $class);

    $paths = [
        "/model/$class.class.php",
        "/controller/$class.class.php",
        "/database/$class.class.php",
        "/backend/$class.class.php",
        "/$class.php",
        "/$class.class.php"
    ];

    foreach ($paths as $path) {
        $fullPath = __DIR__ . $path;
        if (file_exists($fullPath)) {
            require_once $fullPath;
            return;
        }
    }
}

spl_autoload_register("Myautoload");
