<?php

namespace App\Messenger;

class AddProductToCart
{
    public function __construct(
        public readonly string $operationId,
        public readonly string $cartId,
        public readonly string $productId
    ) {}
}
