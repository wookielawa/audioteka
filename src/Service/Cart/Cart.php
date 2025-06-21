<?php

namespace App\Service\Cart;

interface Cart
{
    public function getId(): string;
    public function getTotalPrice(): int;
    public function isFull(): bool;
    /**
     * @return CartProductInterface[]
     */
    public function getCartProducts(): iterable;
}
