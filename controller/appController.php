<?php

namespace controller;

use controller\service\validateService;

class appController extends baseController
{

    /**
     * @var string[] доп переменные в шаблон
     */
    public static $varin = ['form_data' => [], 'warning' => '', 'gooding' => ''];

    /**
     * показ текущего списка элементов
     * @param $twig
     * @return void
     */
    public static function index($twig)
    {

        self::$varin['list'] = [];
        for ($i = 0; $i <= 10; $i++) {
            self::$varin['list'][] = [
                'date' => rand(1980, 2020) . '-' . rand(10, 12) . '-' . rand(10, 28),
                'title' => 'asd' . rand(),
                'opis' => 'asd ' . rand() . 'asd ' . rand() . 'asd ' . rand() . 'asd ' . rand(),
            ];
        }

        echo $twig->render('index.html', self::$varin);

    }

    /**
     * обработка добавления записи
     * @param $twig
     * @return void
     */
    public static function add($twig)
    {

        self::$varin['form_data'] = $_REQUEST;

        self::baseValidate($_REQUEST, [
            'worker' => ['need' => true],
            'email' => [
                'need' => true,
                'type' => 'email'
            ],
            'opis' => ['need' => true],
        ]);

        // если ошибки найдены
        if (!empty(self::$validate_error)) {
            self::$varin['warning'] = self::$validate_error;
        } // ошибок нет > добавляем проверенные данные
        else {

            self::$varin['form_data'] = [];

            // echo __FILE__ . ' ' . __LINE__;
            // echo '<pre>', print_r(self::$validate_datas, true), '</pre>';

            self::$varin['gooding'] = [];
            self::$varin['gooding'][] = 'ЗАпись добавлена';

        }

        self::index($twig);

//        echo '<pre>',print_r($validate::$error),'</pre>';
//        die();


//        $var['list'] => $list , 'warning' => $warning , 'gooding' => $gooding ]

//        $var['list'] = [];
//        for ($i = 0; $i <= 10; $i++) {
//            $var['list'][] = [
//                'title' => 'asd' . rand()
//            ];
//        }
//
//        echo $twig->render('index.html', $var);

    }

}