<?php

use controller\adminController;
use controller\appController;
use controller\baseController;

$loader = new \Twig\Loader\FilesystemLoader('/test231116php/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => 'template_c',
    'auto_reload' => true
]);

// сортировка
// вход выход админ
baseController::setupRequest($_REQUEST);

try {

    $uri = parse_url($_SERVER['REQUEST_URI']);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // сохраняем изменения
        if (strpos($_SERVER['REQUEST_URI'], 'save_edit') && !empty($_POST['id'])) {
            appController::saveEdit($twig, $_POST);
        } elseif ($uri['path'] == '/admin') {
            adminController::enter($_REQUEST, $twig);
        } // обработка добавления
        else {
            appController::add($twig);
        }

    } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        // показ формы редактирования
        if ($uri['path'] == '/edit' && !empty($_REQUEST['id'])) {
            appController::edit($twig, (int)$_REQUEST['id']);
        } elseif ($uri['path'] == '/') {
            appController::index($twig);
        } else if ($uri['path'] == '/install') {
            appController::install($twig);
        } else {
            throw new \Exception('ссылка неверная', 452);
        }

    }

} catch (\Exception $ex) {

    $var_in = ['warning' => [
        'Варнинг! №' . $ex->getCode(),
        $ex->getMessage()
    ]];
    echo $twig->render('index.html', $var_in);

} catch (\Throwable $ex) {

    $var_in = ['warning' => [
        'Варнинг! №' . $ex->getCode(),
        $ex->getMessage()
    ]];
    echo $twig->render('index.html', $var_in);

}