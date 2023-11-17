<?php

namespace controller\service;

use controller\baseController;

class validateService extends baseController
{

    public static $error = [];
    /**
     * массив прошедший проверку
     * @var array
     */
    public static $datas = [];

    function validate($inputs, array $polya_roles): bool
    {

        self::$error = [];
        self::$datas = [];

        foreach ($polya_roles as $pole => $rules) {
            foreach ($rules as $k => $v) {

                // тип поля дата (дата 50 лет туда сюда)
                if ($k == 'type' && $v == 'email') {
                    if ( !filter_var($inputs[$pole], FILTER_VALIDATE_EMAIL) ) {
                        self::$error[] = 'Укажите ' . $pole . ' в формаате даты, 2023-01-01 (не более 50 лет от текущей даты)';
                    }
                }
                // тип почта
                else if ($k == 'type' && $v == 'date') {
                    if ( strtotime($inputs[$pole]) < time()-3600*24*365*50 ||  strtotime($inputs[$pole]) > time()+3600*24*365*50 ) {
                        self::$error[] = 'Укажите ' . $pole . ' в формаате даты, 2023-01-01 (не более 50 лет от текущей даты)';
                    }
                }
                // длинная от
                else if ($k == 'min') {
                    if (strlen($inputs[$pole]) < $v) {
                        self::$error[] = 'Длинна ' . $pole . ' должна быть более ' . $v . ' символа(ов)';
                    }
                }
                self::$datas[$pole] = $inputs[$pole];
            }
        }

        // результат проверки
        return !empty(self::$error) ? false : true;

    }

}