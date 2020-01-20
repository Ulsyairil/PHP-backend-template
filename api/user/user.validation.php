<?php

namespace API\User;

require_once(__DIR__ . "/../../vendor/autoload.php");
require_once(__DIR__ . "/../../helpers/uniquerule.helper.php");

use Rakit\Validation\Validator;
use Helpers\UniqueRule;

class UserRequest
{
    public static function rules($request)
    {
        $validator = new Validator;

        $rules = [
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'nama_lengkap' => 'required',
            'kartu_pengenal' => 'required',
            'no_kartu' => 'required|numeric',
        ];

        $validator->setMessages([
            'required' => ':attribute harus diisi',
            'min' => ':attribute harus lebih dari :min karakter',
            'same' => ':attribute harus sama dengan :same',
            'unique' => ':attribute sudah digunakan',
            'email' => ':email tidak valid',
            'numeric' => ':attribute harus angka'
        ]);

        switch ($_SERVER['PHP_SELF']) {
            case '/create.php':
                $validator->addValidator('unique', new UniqueRule());
                $validation = $validator->validate($request, $rules);
                break;

            case '/update.php':
                $rules = [];
                $rules['email'] = 'required|email';
                $validation = $validator->validate($request, $rules);
                break;

            default:
                $validation = $validator->validate($request, $rules);
                break;
        }

        if (!$validation) {
            $error = $validation->errors();
            throw new \Exception($error->firstOfAll(), 400);
        }

        return $validation;
    }
}
