<?php namespace KBC\Accounts\Commands;

class DeleteAccount
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
