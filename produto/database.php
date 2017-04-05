<?php
/**
 * Created by PhpStorm.
 * User: vieira
 * Date: 04/04/2017
 */

namespace produto;
use \PDO;

class database
{
    const HOST = 'localhost';
    const DB = 'ph2';
    const USER = 'root';
    const PASSWORD = "";
    public static $instance;

    public function __construct()
    {

    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $user = self::USER;
            $password = self::PASSWORD;
            $host = self::HOST;
            $db = self::DB;
            try {
                self::$instance = new PDO("mysql:host=$host;dbname=$db",$user, $password);
                
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            } catch ( \PDOException $e )
            {
                echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
            }

        }

        return self::$instance;
    }
}