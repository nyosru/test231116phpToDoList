<?php

namespace controller\service;

use controller\baseController;
use model\ItemsModel;

class dbService extends baseController
{

    public $connect = false;

    public $db_file = 'db.sqlite';

    /**
     * PDO instance
     * @var type
     */
    private $pdo;

    function __construct()
    {
        $this->connect();
    }

    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return \PDO
     */
    public function connect()
    {
        if (empty($this->pdo)) {
            $this->pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/' . $this->db_file);
        }
        return $this->pdo;
    }

    public function insert(string $table, array $data)
    {
        $db = $this->connect();
        $sql = 'INSERT INTO ' . $table . ' ( title , mail , opis , finished ) VALUES (:title, :mail, :opis , :finished )';
        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }

    public function install()
    {

        try {

            $sql = 'CREATE TABLE IF NOT EXISTS Task ( 
                id INTEGER AUTO_INCREMENT PRIMARY KEY, 
                title VARCHAR(200), 
                mail  VARCHAR(200), 
                opis TEXT, 
                finished BOOL );';
            $this->pdo->exec($sql);

            $sql = 'DELETE FROM Task;';
            $this->pdo->exec($sql);

            // сидируем модельку
            for ($i = 0; $i <= 9; $i++) {
                $this->insert('Task', [
                    'title' => 'рандом текс и цифра ' . rand(),
                    'mail' => 'mail@mail.ru',
                    'opis' => 'Стартовое описание Стартовое описание Стартовое описание Стартовое описание',
                    'finished' => (rand(1, 2) == 1 ? true : false)
                ]);
            }

        } catch (\PDOException $ex) {
            echo 'Ошибка БД (';
            echo '<pre>';
            print_r($ex);
            echo '</pre>';
        }

    }

    public function getData()
    {
        $sql = 'SELECT * FROM Task LIMIT 50;';
        // выполняем SQL-выражение
        return $this->pdo->exec($sql);

    }

}