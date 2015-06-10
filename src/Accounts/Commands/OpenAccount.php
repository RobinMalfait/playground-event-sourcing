<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\Name;

class OpenAccount
{
    public $id;

    public $name;

    public function __construct($id, Name $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}
