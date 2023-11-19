<?php

namespace controller\service;

use controller\baseController;
use Faker\Factory;
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
        $sql = 'INSERT INTO ' . $table . ' ( worker , mail , opis , finished ) VALUES (:worker, :mail, :opis , :finished )';
        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete(string $table, int $id)
    {
        $db = $this->connect();
        $sql = 'DELETE FROM ' . $table . ' WHERE id = :id';
        $stmt = $db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function update(string $table, int $id, $values )
    {
        $db = $this->connect();

        $data_in_sql = [];
        $sql_set = '';
        foreach( $values as $k => $v ){

            if( !empty($sql_set))
                $sql_set .= ',';

            $sql_set .= $k.' = :'.$k.' ';
            $data_in_sql[$k] = $v;
        }

        $data_in_sql['id'] = $id;

        $sql = 'UPDATE '.$table.' SET '.$sql_set.' WHERE id = :id ';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data_in_sql);

//        $sql = 'DELETE FROM ' . $table . ' WHERE id = :id';
//        $stmt = $db->prepare($sql);
//        return $stmt->execute(['id' => $id]);
    }

    public function install()
    {

        try {

            $sql = 'CREATE TABLE IF NOT EXISTS Task ( 
                id INTEGER  primary key autoincrement , 
                worker VARCHAR(200), 
                mail  VARCHAR(200), 
                opis TEXT, 
                finished BOOLEAN     
    
                );';
            $this->pdo->exec($sql);

            $sql = 'DELETE FROM Task;';
            $this->pdo->exec($sql);

            // use the factory to create a Faker\Generator instance
            $faker = Factory::create();

            // сидируем модельку
            for ($i = 0; $i <= 9; $i++) {
                $this->insert('Task', [
//                    'worker' => 'user ' . rand(),
                    'worker' => $faker->name(),
//                    'mail' => 'mail@mail.ru',
                    'mail' => $faker->email(),
//                    'opis' => 'Стартовое описание Стартовое описание Стартовое описание Стартовое описание',
                    'opis' => $faker->text(),
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

    public function getData($table, $id = null)
    {

        $db = $this->connect();

        if (!empty($id)) {
            $sql = 'SELECT * FROM ' . $table . ' WHERE `id` = ' . ((int)$id) . '  ;';
        } else {
            $sql = 'SELECT * FROM ' . $table . ' LIMIT 50;';
        }

        $row = $db->query($sql);
        return $row->fetchAll();

    }

}