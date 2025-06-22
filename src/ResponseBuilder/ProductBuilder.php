<?php

namespace App\ResponseBuilder;

use App\Service\Catalog\Product;

class ProductBuilder
{
    public function __invoke(Product $product): array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'createdAt' => $product->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}