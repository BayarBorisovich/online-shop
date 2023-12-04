<?php

class Model
{
    protected PDO $PDO;
    protected static PDO $PDO1;

    public function __construct()
    {
        $this->PDO = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
    }
    public static function getPdo1(): void
    {
        self::$PDO1 = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
    }
}
