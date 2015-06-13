<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\Name;

final class OpenAccount
{
    private $id;

    private $name;

    public function __construct($id, Name $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }
}
