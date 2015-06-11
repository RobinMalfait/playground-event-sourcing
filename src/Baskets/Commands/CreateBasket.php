<?php namespace KBC\Baskets\Commands;

final class CreateBasket
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
