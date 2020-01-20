<?php

namespace Database\Drop;

require_once(__DIR__ . '/../config/database.php');

use Config\Database;

class Table
{
    public function drop()
    {
        try {
            $database = new Database;
            $database = $database->mysql();
            $database->drop('users');
            echo "Success drop table";
        } catch (\Exception $error) {
            echo $error->getMessage();
        }
    }
}
