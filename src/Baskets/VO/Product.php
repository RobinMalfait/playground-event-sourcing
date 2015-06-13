<?php namespace KBC\Baskets\VO;

final class Product
{
    private $productId;

    private $name;

    public function __construct(ProductId $productId, $name)
    {
        $this->productId = $productId;
        $this->name = $name;
    }

    /**
     * @return ProductId
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}
