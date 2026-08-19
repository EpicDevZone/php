<?php
spl_autoload_register(function ($className) {

    //! Example input: App\Models\User
    //! Example output: /base/dir/Models/User.php


    //! Only load classes that belong to the App namespace.
    $prefix = "App\\";
    $baseDir = dirname(__DIR__) . '/';

    if (strpos($className, $prefix) !== 0) {
        return;
    }
    //! Remove the namespace prefix before creating the file path.
    $relativeClass = substr($className, strlen($prefix));


    //! Convert the class name into the matching PHP file name.
    $file =  str_replace('\\', '/',  $baseDir . $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});
