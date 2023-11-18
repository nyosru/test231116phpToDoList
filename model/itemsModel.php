<?php

namespace model;

use controller\service\dbService;

class ItemsModel extends \controller\service\dbService
{

    public function get()
    {
//        $this->connect();
    }

    /**
     * @param array $data [ 'title' ==> string 200 , 'mail' => string 200, 'opis' TEXT, finished BOOL ]
     * @return void
     */
    public function add(array $data)
    {
//        $db = new dbService();
//        $sql = "INSERT INTO `Task` ( title , mail , opis , finished ) VALUES (:title, :mail, :opis , :finished )";
//        $stmt = $db->prepare($sql);
//        $stmt->execute($data);
        $ee = $this->insert('Task', $data);
//        echo '<pre>',print_r($ee);
//        self::dd($ee);
    }

}