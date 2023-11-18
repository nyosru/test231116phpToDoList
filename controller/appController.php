<?php

namespace controller;

use controller\service\dbService;
use controller\service\validateService;

class appController extends baseController
{

    /**
     * @var string[] доп переменные в шаблон
     */
    public static $var_in = ['form_data' => [], 'warning' => '', 'gooding' => ''];

    /**
     * показ текущего списка элементов
     * @param $twig
     * @return void
     */
    public static function index($twig)
    {

//        $db = new dbService();
//        $db->connect();
//        $data = $db->getData();
//        self::dd($data);

        self::$var_in['list'] = [];
        for ($i = 0; $i <= 10; $i++) {
            self::$var_in['list'][] = [
                'date' => rand(1980, 2020) . '-' . rand(10, 12) . '-' . rand(10, 28),
                'title' => 'asd' . rand(),
                'opis' => 'asd ' . rand() . 'asd ' . rand() . 'asd ' . rand() . 'asd ' . rand(),
            ];
        }

        echo $twig->render('index.html', self::$var_in);

    }

    /**
     * установка бд и всё такое
     * @return void
     */
    public static function install(): void
    {

        $db = new dbService();
        // создаём таблички если нет, удаляем всё, заливаем тест данные
        $db->install();
        echo '<div style="text-align:Center; margin-top: 40vh; font-size:2rem;" >установка проведена, <a href="/">переходите на гланую страницу</a></div>';

        return;

    }

    /**
     * обработка добавления записи
     * @param $twig
     * @return void
     */
    public static function add($twig)
    {

        self::$var_in['form_data'] = $_REQUEST;

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
            self::$var_in['warning'] = self::$validate_error;
        } // ошибок нет > добавляем проверенные данные
        else {

            self::$var_in['form_data'] = [];

            // echo __FILE__ . ' ' . __LINE__;
            // echo '<pre>', print_r(self::$validate_datas, true), '</pre>';

            self::$var_in['gooding'] = [];
            self::$var_in['gooding'][] = 'ЗАпись добавлена';

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