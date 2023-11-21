<?php

use controller\adminController;
use controller\appController;
use controller\baseController;

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
//        'cache' => __DIR__ . '/templates_cache',
]);

$uri = parse_url($_SERVER['REQUEST_URI']);

// сортировка
// вход выход админ
baseController::setupRequest($_REQUEST);

try {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // сохраняем изменения
        if (strpos($_SERVER['REQUEST_URI'], 'save_edit') && !empty($_POST['id'])) {
            appController::saveEdit($twig, $_POST);
        }
        elseif($uri['path'] == '/admin'){
            adminController::enter($_REQUEST,$twig);
        }
        // обработка добавления
        else {
            // echo '<pre>',print_r($_POST),'</pre>';
            appController::add($twig);
        }

    } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        // удаляем
        if ($uri['path'] == '/delete' && !empty($_REQUEST['id'])) {
            appController::delete($twig, (int)$_REQUEST['id']);
        } // показ формы редактирования
        else if ($uri['path'] == '/edit' && !empty($_REQUEST['id'])) {
            appController::edit($twig, (int)$_REQUEST['id']);
        } elseif ($uri['path'] == '/') {
//            echo 'start';
            appController::index($twig);
        } else if ($uri['path'] == '/install') {
//            echo 'start';
            appController::install($twig);
        } else {
//            echo '<div style="text-align:center;font-size:2rem; margin-top:40vh;" >нет такой страницы <a href="/">Перейти на первую страницу</a></div>';
            throw new \Exception('ссылка неверная', 452);
        }

    }

//    echo '<br/>';
//    echo '<br/>';
//    echo '<br/>';
//
//    echo '<pre>', print_r(
//        [__FILE__,
//            '$_SERVER' => $_SERVER,
//            $_GET,
//            '$_SERVER[REQUEST_METHOD]' => $_SERVER['REQUEST_METHOD']
//        ], true), '</pre>';
//    die();

} catch (\Exception $ex) {

//    echo '<pre>', print_r($ex), '</pre>';
//    echo '<pre>', print_r($ex->getMessage()), '</pre>';
    echo '<pre>', print_r($_SERVER), '</pre>';

    $var_in = ['warning' => [
        'Варнинг! №' . $ex->getCode(),
        $ex->getMessage()
    ]];
    echo $twig->render('index.html', $var_in);

} catch (\Throwable $ex) {

    echo '<pre>', print_r($ex), '</pre>';
    echo '<pre>', print_r($ex->getMessage()), '</pre>';

}