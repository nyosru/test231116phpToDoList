<?php

namespace controller;

use controller\service\validateService;

class baseController
{

    public static $validate_error = [];
    public static $validate_datas = [];

    public static function setupRequest($request)
    {

        // прогрев
        if (!isset($_SESSION['sort']))
            $_SESSION['sort'] = [
                'worker' => '',
                'mail' => '',
                'finished' => ''
            ];

        // изменения
//        echo '<pre>';
//        print_r($_REQUEST);
//        echo '$_SESSION';
//        print_r($_SESSION);

        foreach ($_SESSION['sort'] as $k => $v) {
            if (isset($_REQUEST['sortBy'][$k])) {
                $_SESSION['sort'][$k] = $_REQUEST['sortBy'][$k];
            }
        }

    }

    public
    static function baseValidate($data, $rules)
    {
        $validate = new validateService();
        $validate->validate($data, $rules);
        self::$validate_error = $validate::$error;
        self::$validate_datas = $validate::$datas;
    }

    public
    static function dd($array)
    {
        echo '<pre>', print_r($array), '</pre>';
    }

    public
    static function secretCreate(string $string): string
    {
        return md5('соль ' . $string);
    }

    public
    static function secretCheck(string $string, string $secret): bool
    {
        return md5('соль ' . $string) == $secret;
    }

}