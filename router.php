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