<?php

namespace controller;

use controller\service\dbService;
use controller\service\validateService;
use model\ItemsModel;

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

        $items = new ItemsModel();
        self::$var_in['pages'] = $items->getPages(3, $_REQUEST['page'] ?? 1);
        self::$var_in['list'] = $items->getItems(self::$var_in['pages']['now']);
        self::$var_in['sort'] = $_SESSION['sort'] ?? [];

        self::$var_in['admin'] = $_SESSION['admin'] ?? false;

        self::$var_in['admin_flash'] = $_SESSION['admin_flash'] ?? '';
        $_SESSION['admin_flash'] = '';

        echo $twig->render('index.html', self::$var_in);

    }

    /**
     * установка бд и всё такое
     * создаём таблички если нет, удаляем всё, заливаем тест данные
     * @return void
     */
    public static function install(): void
    {
        $db = new dbService();
        $db->install();
        echo '<div style="text-align:Center; margin-top: 40vh; font-size:2rem;" >установка проведена, <a href="/">переходите на гланую страницу</a></div>';
    }

    /**
     * обработка удаления записи
     * @param $twig
     * @return void
     */
    public static function delete($twig, $id)
    {
        $item = new ItemsModel();
        $item->deleteItem($id);
        self::$var_in['warning'] = ['ЗАпись №' . $id . ' удалена'];
        self::index($twig);
    }

    /**
     * показ формы редактирование записи
     * @param $twig
     * @return void
     */
    public static function edit($twig, $id)
    {

        $item = new ItemsModel();
        self::$var_in['edit_item'] = $item->getData('Task', $id);

        if (empty(self::$var_in['edit_item'][0]))
            throw new \Exception('вот вот и получится, но пока не прокатит (нет итема)', 451);

        self::$var_in['form_data'] = self::$var_in['edit_item'][0];
        self::$var_in['form_data']['secret'] = self::secretCreate($id);
        self::index($twig);
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
            'mail' => [
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

            $items = new ItemsModel();
            $in = self::$validate_datas;
            $in['finished'] = false;

            $items->add($in);
            self::$var_in['form_data'] = [];

            self::$var_in['gooding'] = [];
            self::$var_in['gooding'][] = 'Запись добавлена';

        }

        self::index($twig);

    }

    /**
     * обработка изменения записи
     * @param $twig
     * @return void
     */
    public static function saveEdit($twig)
    {

        if ($_SESSION['admin'] === true) {


            self::$var_in['form_data'] = $_POST;

            self::baseValidate($_POST, [
                'opis' => ['need' => true],
            ]);

            // если проверка секрета не прошла
            if (!self::secretCheck($_POST['id'] ?? 'x', $_POST['secret'] ?? 'x')) {
                throw new \Exception('Что то пошло не так', 400);
            }

            // если ошибки найдены
            if (!empty(self::$validate_error)) {
                self::$var_in['warning'] = self::$validate_error;
            } // ошибок нет > добавляем проверенные данные
            else {
                self::$var_in['form_data'] = [];

                $items = new ItemsModel();

                $datain = [
                    'opis' => self::$validate_datas['opis'],
                    'finished' => !empty($_POST['finished']) ? true : false
                ];
                $items->updateItem($_POST['id'], $datain);

                self::$var_in['gooding'] = ['Запись #' . $_POST['id'] . ' изменена'];

            }
        } // если не авторизован
        else {
            throw new \Exception('чтобы сохранить изменения пройдите авторизацию и повторите', 453);
        }

        self::index($twig);

    }

}