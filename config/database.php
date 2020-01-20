<?php

namespace Config;

require_once(__DIR__ . "/../vendor/autoload.php");

use Medoo\Medoo;

class Database
{
    public function mysql()
    {
        $database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'tugas4',
            'server' => 'localhost',
            'username' => 'root',
            'password' => '',
        ]);
        return $database;
    }
}
