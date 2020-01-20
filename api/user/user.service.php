<?php

namespace Api\User;

require_once(__DIR__ . "/../../vendor/autoload.php");
require_once(__DIR__ . "/../../config/database.php");

use Carbon\Carbon;
use Config\Database;
use Exception;

class UserService
{
    public function show()
    {
        $database = new Database;
        $database = $database->mysql();
        $show = $database->select("users", [
            "username",
            "email",
            "password",
            "nama_lengkap",
            "kartu_pengenal",
            "no_kartu",
            "created_at",
            "updated_at",
        ], [
            "deleted_at" => null
        ]);
        http_response_code(200);
        return json_encode([
            "code" => 200,
            "status" => "success",
            "message" => "success get all data",
            "data" => $show
        ]);
    }

    public function get($id)
    {
        $database = new Database;
        $database = $database->mysql();
        $show = $database->select("users", [
            "username",
            "email",
            "password",
            "nama_lengkap",
            "kartu_pengenal",
            "no_kartu",
            "created_at",
            "updated_at",
        ], [
            "id" => $id,
            "deleted_at" => null
        ]);
        http_response_code(200);
        return json_encode([
            "code" => 200,
            "status" => "success",
            "message" => "success get all data",
            "data" => $show
        ]);
    }

    public function count($id)
    {
        $database = new Database;
        $database = $database->mysql();
        $count = $database->count("users", [
            "id" => $id,
            "deleted_at" => null
        ]);
        return (int) $count;
    }

    public function create($username, $email, $password, $nama, $kartu, $no)
    {
        $database = new Database;
        $database = $database->mysql();
        $database->insert("users", [
            "username" => $username,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_BCRYPT),
            "nama_lengkap" => $nama,
            "kartu_pengenal" => $kartu,
            "no_kartu" => $no,
            "created_at" => Carbon::now()
        ]);
        if (!$database) {
            throw new Exception($database->error(), 400);
            exit;
        }
        $id = $database->id();
        $show = $database->select("users", "*", [
            "id" => $id
        ]);
        http_response_code(200);
        return json_encode([
            "code" => 200,
            "status" => "success",
            "message" => "success insert data",
            "data" => $show
        ]);
    }

    public function update($id, $username, $email, $password, $nama, $kartu, $no)
    {
        $database = new Database;
        $database = $database->mysql();
        $database->update("users", [
            "username" => $username,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_BCRYPT),
            "nama_lengkap" => $nama,
            "kartu_pengenal" => $kartu,
            "no_kartu" => $no,
            "updated_at" => Carbon::now()
        ], [
            "id" => $id
        ]);
        if (!$database) {
            throw new Exception($database->error(), 400);
            exit;
        }
        $show = $database->select("users", "*", [
            "id" => $id
        ]);
        http_response_code(200);
        return json_encode([
            "code" => 200,
            "status" => "success",
            "message" => "success update data",
            "data" => $show
        ]);
    }

    public function softDelete($id)
    {
        $database = new Database;
        $database = $database->mysql();
        $database->update("users", [
            "deleted_at" => Carbon::now()
        ], [
            "id" => $id
        ]);
        if (!$database) {
            throw new Exception($database->error(), 400);
            exit;
        }
        http_response_code(200);
        return json_encode([
            "code" => 200,
            "status" => "success",
            "message" => "success delete data"
        ]);
    }
}
