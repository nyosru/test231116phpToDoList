<?php

use controller\appController;

//    $app = new \controller\appController();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
//        'cache' => __DIR__ . '/templates_cache',
]);

try {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // сохраняем изменения
        if (strpos($_SERVER['REQUEST_URI'], 'save_edit') && !empty($_POST['id'])) {
            appController::saveEdit($twig, $_POST);
        } // обработка добавления
        else {
            // echo '<pre>',print_r($_POST),'</pre>';
            appController::add($twig);
        }

    } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        // удаляем
        if (strpos($_SERVER['REQUEST_URI'], 'delete') && !empty($_REQUEST['id'])) {
            appController::delete($twig, (int)$_REQUEST['id']);
        } // показ формы редактирования
        else if (strpos($_SERVER['REQUEST_URI'], 'edit') && !empty($_REQUEST['id'])) {
            appController::edit($twig, (int)$_REQUEST['id']);
        } elseif ($_SERVER['REQUEST_URI'] == '/') {
//            echo 'start';
            appController::index($twig);
        } else if ($_SERVER['REQUEST_URI'] == '/install') {
//            echo 'start';
            appController::install($twig);
        } else {
            echo '<div style="text-align:center;font-size:2rem; margin-top:40vh;" >нет такой страницы <a href="/">Перейти на первую страницу</a></div>';
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
    $var_in = ['warning' => [
        'Варнинг! №' . $ex->getCode(),
        $ex->getMessage()
    ]];
    echo $twig->render('index.html', $var_in);

} catch (\Throwable $ex) {

    echo '<pre>', print_r($ex), '</pre>';
    echo '<pre>', print_r($ex->getMessage()), '</pre>';

}