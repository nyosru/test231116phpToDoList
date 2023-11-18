<?php

namespace controller\service;

use controller\baseController;

class dbService extends baseController
{

    public $connect = false;

    public $db_file = 'sqlite.db';

//    public function connect(){
//        $conn = new PDO("mysql:host=localhost;dbname=testdb1", "root", "mypassword");
//    }

    /**
     * PDO instance
     * @var type
     */
    private $pdo;

    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return \PDO
     */
    public function connect()
    {
        if ($this->pdo == null) {
            $this->pdo = new \PDO("sqlite:" . $this->db_file);
            if (!filesize($this->db_file))
                throw new \Exception('There are no tables in the database!');
        }
        return $this->pdo;
    }

    public function getData()
    {
    }
//try {
//$conn = new PDO("mysql:host=localhost;dbname=testdb1", "root", "mypassword");
//
//    // SQL-выражение для добавления данных
//$sql = "INSERT INTO Users (name, age) VALUES ('Tom', 37)";
//
//$affectedRowsNumber = $conn->exec($sql);
//echo "В таблицу Users добавлено строк: $affectedRowsNumber";
//}
//catch (PDOException $e) {
//    echo "Database error: " . $e->getMessage();
//}

}