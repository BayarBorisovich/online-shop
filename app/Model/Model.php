<?php

class Model
{
    protected static PDO $PDO;

    public static function getPDO(): PDO
    {
        if (isset(self::$PDO)) {
            return self::$PDO;
        }
        self::$PDO = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        return self::$PDO;
    }
}
