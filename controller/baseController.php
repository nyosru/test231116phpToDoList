<?php

namespace controller;

use controller\service\validateService;

class baseController
{

    public static $validate_error = [];
    public static $validate_datas = [];

    public static function baseValidate($data, $rules)
    {
        $validate = new validateService();
        $validate->validate($data, $rules);
        self::$validate_error = $validate::$error;
        self::$validate_datas = $validate::$datas;
    }

}