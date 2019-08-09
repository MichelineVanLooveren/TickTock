<?php

    abstract class Db
    {
        private static $conn;

        public static function getInstance() //connectie met DB maken
        {
            if (self::$conn != null) {
                // Is connectie al eerder gemaakt? Return connectie
                return self::$conn;
            } else {
                $config = parse_ini_file('config/config.ini');
                // Nog geen connectie? Maak een connectie
                self::$conn = new PDO('mysql:host='.$config['host'].';port='.$config['port'].';dbname='.$config['db_name'], $config['db_user'], $config['db_password']);

                return self::$conn;
            }
        }
    }
