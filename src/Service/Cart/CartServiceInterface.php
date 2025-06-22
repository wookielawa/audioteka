<?php

namespace App\Service\Cart;

use App\Service\Catalog\Product;

interface CartServiceInterface
{
    public function addProduct(string $operationId, string $cartId, string $productId): void;

    public function removeProduct(string $cartId, string $productId): void;

    public function create(): Cart;
}