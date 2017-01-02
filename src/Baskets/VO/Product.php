<?php namespace KBC\Baskets\VO;

final class Product
{
    /** @var \KBC\Baskets\VO\ProductId */
    private $productId;

    /** @var string */
    private $name;

    public function __construct(ProductId $productId, $name)
    {
        $this->productId = $productId;
        $this->name = $name;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getName()
    {
        return $this->name;
    }
}
