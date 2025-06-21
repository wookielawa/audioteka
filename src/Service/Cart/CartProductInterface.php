<?php

namespace App\Service\Cart;

use App\Service\Catalog\Product;

interface CartProductInterface
{
    public function getId(): ?int;
    public function getCart(): ?Cart;
    public function getProduct(): ?Product;
    public function getQuantity(): int;
    public function setCart(?Cart $cart): void;
    public function setProduct(?Product $product): void;
    public function setQuantity(int $quantity): void;
    public function increaseQuantity(): void;
    public function decreaseQuantity(): void;
}