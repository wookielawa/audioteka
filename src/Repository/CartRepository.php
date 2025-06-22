<?php

namespace App\Repository;

use App\Entity\CartAddProductStatus;
use App\Entity\Product;
use App\Service\Cart\Cart;
use App\Service\Cart\CartServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class CartRepository implements CartServiceInterface
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function addProduct(string $operationId, string $cartId, string $productId): void
    {
        $cartAddProductStatus = new CartAddProductStatus($operationId);

        $cart = $this->entityManager->find(\App\Entity\Cart::class, $cartId);
        $product = $this->entityManager->find(Product::class, $productId);

        if ($cart && $cart->isFull()) {
            $cartAddProductStatus->setMessage('Cart is full.');

            $this->entityManager->persist($cartAddProductStatus);
            $this->entityManager->flush();

            return;
        }

        if ($cart && $product) {
            $cart->addProduct($product);
            $this->entityManager->persist($cart);
            $this->entityManager->flush();

            $cartAddProductStatus->setMessage('OK');
            $this->entityManager->persist($cartAddProductStatus);
            $this->entityManager->flush();
        }
    }

    public function removeProduct(string $cartId, string $productId): void
    {
        $cart = $this->entityManager->find(\App\Entity\Cart::class, $cartId);
        $product = $this->entityManager->find(Product::class, $productId);

        if ($cart && $product && $cart->hasProduct($product)) {
            $cart->removeProduct($product);
            $this->entityManager->persist($cart);
            $this->entityManager->flush();
        }
    }

    public function create(): Cart
    {
        $cart = new \App\Entity\Cart(Uuid::uuid4()->toString());

        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $cart;
    }
}