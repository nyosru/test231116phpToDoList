<?php

namespace controller;

use controller\service\dbService;
use controller\service\validateService;
use model\ItemsModel;

class adminController extends baseController
{

    /**
     * вход выход админа
     * @param $request
     * @param $twig
     * @return void
     */
    public static function enter($request, $twig)
    {

        if (isset($request['exit'])) {
            $_SESSION['admin'] = false;
        } else if ($request['login'] == 'admin' && $request['password'] == '123') {
            $_SESSION['admin'] = true;
        } else {
            $_SESSION['admin'] = false;
            $_SESSION['admin_flash'] = 'Логин Пароль указаны неверно';

        }

        appController::index($twig);
    }
}