<?php

class Model
{
    protected PDO $PDO;

    public function __construct()
    {
        $this->PDO = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
    }
}
