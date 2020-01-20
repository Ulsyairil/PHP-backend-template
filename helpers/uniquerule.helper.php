<?php

namespace Helpers;

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/../config/database.php");

use Rakit\Validation\Rule;
use Config\Database;

class UniqueRule extends Rule
{
    protected $message = ":attribute :value has been used";

    protected $fillableParams = ['table', 'column', 'except'];

    public function check($value): bool
    {
        $database = new Database;
        $database = $database->mysql();

        // make sure required parameters exists
        $this->requireParameters(['table', 'column']);

        // getting parameters
        $column = $this->parameter('column');
        $table = $this->parameter('table');
        $except = $this->parameter('except');

        if ($except and $except == $value) {
            return true;
        }

        // do query
        $data = $database->count($table, [
            $column => $value
        ]);

        // true for valid, false for invalid
        return intval($data) === 0;
    }
}
