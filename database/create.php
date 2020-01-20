<?php

namespace Database\Migrate;

require_once(__DIR__ . '/../config/database.php');

use Config\Database;

class Table
{
    public function create()
    {
        try {
            $this->create_user_table();
            echo "Success migrate";
        } catch (\Exception $error) {
            echo $error->getMessage();
        }
    }

    protected function create_user_table()
    {
        $database = new Database;
        $database = $database->mysql();
        $database->create("users", [
            "id" => [
                "BIGINT",
                "NOT NULL",
                "AUTO_INCREMENT",
                "PRIMARY KEY"
            ],
            "username" => [
                "VARCHAR(255)",
                "NOT NULL",
                "UNIQUE"
            ],
            "email" => [
                "VARCHAR(255)",
                "NOT NULL",
                "UNIQUE"
            ],
            "password" => [
                "TEXT",
                "NOT NULL"
            ],
            "nama_lengkap" => [
                "VARCHAR(255)",
                "NOT NULL",
            ],
            "kartu_pengenal" => [
                "ENUM('ktp','sim')",
                "NOT NULL"
            ],
            "no_kartu" => [
                "INTEGER",
                "NOT NULL"
            ],
            "created_at" => [
                "DATETIME",
                "NOT NULL"
            ],
            "updated_at" => [
                "DATETIME"
            ],
            "deleted_at" => [
                "DATETIME"
            ]
        ]);
        return $database;
    }
}
