<?php

namespace App\Messenger;

class EditProduct
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int $price
    ) {}
}
