<?php

//die([ __FILE__, __LINE__]);

require __DIR__ . '/../vendor/autoload.php';

spl_autoload_register(function ($class_name) {
//    echo '<br/>';
//    echo __DIR__.'/../controller/'.$class_name . '.php';
//    echo '<br/>';
//    include __DIR__.'/../controller/'.$class_name . '.php';
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/../' . str_replace('\\', '/', $class_name) . '.php')) {
        include $_SERVER['DOCUMENT_ROOT'] . '/../' . str_replace('\\', '/', $class_name) . '.php';
    }
//    elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . '/../service/' . str_replace('\\', '/', $class_name) . '.php')) {
//        include $_SERVER['DOCUMENT_ROOT'] . '/../service/' . str_replace('\\', '/', $class_name) . '.php';
//    }
});


require __DIR__ . '/../router.php';