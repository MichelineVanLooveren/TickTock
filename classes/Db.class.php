<?php

//connectie maken met db
class DAO
{ //data access object
    // Properties
    private static $dbHost = 'localhost';
    private static $dbName = 'bureau1q_todo';
    private static $dbUser = 'bureau1q_MVL';
    private static $dbPass = 'tG6gW;hTrb55';
    private static $sharedPDO; //slaagt connectie hieronder op
    protected $pdo;

    // Constructor
    public function __construct()
    {
        if (empty(self::$sharedPDO)) {
            self::$sharedPDO = new PDO('mysql:host='.self::$dbHost.';dbname='.self::$dbName, self::$dbUser, self::$dbPass);
            self::$sharedPDO->exec('SET CHARACTER SET utf8');
            self::$sharedPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$sharedPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }

        $this->pdo = &self::$sharedPDO;
    }
}
