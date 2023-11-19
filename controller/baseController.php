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

    public static function dd($array){
        echo '<pre>',print_r($array),'</pre>';
    }

    public static function secretCreate( string $string): string
    {
        return md5('соль '.$string );
    }

    public static function secretCheck( string $string, string $secret ): bool
    {
        return md5('соль '.$string ) == $secret ;
    }

}