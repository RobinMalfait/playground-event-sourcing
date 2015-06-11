<?php namespace KBC\Accounts\Commands;

class CloseAccount
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
