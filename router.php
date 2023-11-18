<?php

use controller\appController;

try {

//    $app = new \controller\appController();

    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
    $twig = new \Twig\Environment($loader, [
//        'cache' => __DIR__ . '/templates_cache',
    ]);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//        echo '<pre>',print_r($_POST),'</pre>';
        return appController::add($twig);

    } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        if ($_SERVER['REQUEST_URI'] == '/') {
//            echo 'start';
            return appController::index($twig);
        } else if ($_SERVER['REQUEST_URI'] == '/install') {
//            echo 'start';
            return appController::install($twig);
        } else {
            echo 'нет такого адреса ';
        }

    }

    echo '<br/>';
    echo '<br/>';
    echo '<br/>';

    echo '<pre>', print_r(
        [__FILE__,
            '$_SERVER' => $_SERVER,
            $_GET,
            '$_SERVER[REQUEST_METHOD]' => $_SERVER['REQUEST_METHOD']
        ], true), '</pre>';
    die();

} catch (\Exception $ex) {
    echo '<pre>', print_r($ex), '</pre>';
    echo '<pre>', print_r($ex->getMessage()), '</pre>';
} catch (\Throwable $ex) {
    echo '<pre>', print_r($ex), '</pre>';
    echo '<pre>', print_r($ex->getMessage()), '</pre>';
}