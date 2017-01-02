<?php namespace Acme\Baskets\VO;

final class ProductId
{

    /** @var string */
    private $id;

    private function __construct($id)
    {
        $this->id = $id;
    }

    public static function fromString($id)
    {
        return new self($id);
    }

    public function getId()
    {
        return $this->id;
    }
}
