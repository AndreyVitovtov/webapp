<?php

namespace App\Utility;

use PDO;
use PDOException;

class Database
{
    private $dbh;
    private static $inst = NULL;

    private function __construct()
    {
        $this->connect();
    }

    private function connect(): void
    {
        try {
            $this->dbh = new PDO(
                "mysql:dbname=" . DB_NAME . ";host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4",
                DB_USERNAME,
                DB_PASSWORD,
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => true,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                ]
            );
        } catch (PDOException $e) {
            die("Error connection: " . $e->getMessage());
        }
    }

    public function checkConnection(): void
    {
        try {
            $this->dbh->query("SELECT 1");
        } catch (PDOException $e) {
            if (str_contains($e->getMessage(), 'MySQL server has gone away')) {
                $this->reconnect();
            }
        }
    }

    private function reconnect(): void
    {
        $this->connect();
    }

    public function getDbh(): PDO
    {
        $this->checkConnection();
        return $this->dbh;
    }

    public static function instance(): Database
    {
        if (self::$inst !== NULL) {
            self::$inst->checkConnection();
            return self::$inst;
        }

        return self::$inst = new self();
    }
}