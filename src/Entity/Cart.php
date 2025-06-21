<?php

namespace App\Entity;

use App\Service\Catalog\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Cart implements \App\Service\Cart\Cart
{
    public const CAPACITY = 3;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: CartProduct::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $cartProducts;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
        $this->cartProducts = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getTotalPrice(): int
    {
        return array_reduce(
            $this->cartProducts->toArray(),
            static fn(int $total, CartProduct $cartProduct): int => $total + $cartProduct->getQuantity() * $cartProduct->getProduct()->getPrice(),
            0
        );
    }

    #[Pure]
    public function isFull(): bool
    {
        $counted = array_sum(
            $this->cartProducts->map(fn($product) => $product->getQuantity())->toArray()
        );

        return $counted >= self::CAPACITY;
    }

    public function getCartProducts(): iterable
    {
        return $this->cartProducts->getIterator();
    }

    #[Pure]
    public function hasProduct(\App\Entity\Product $product): bool
    {
        foreach ($this->cartProducts as $cartProduct) {
            if ($cartProduct->getProduct() === $product) {
                return true;
            }
        }

        return false;
    }

    public function addProduct(Product $product): void
    {
        foreach ($this->cartProducts as $cartProduct) {
            if ($cartProduct->getProduct() === $product) {
                $cartProduct->increaseQuantity();
                return;
            }
        }

        $cartProduct = new CartProduct();
        $cartProduct->setCart($this);
        $cartProduct->setProduct($product);
        $cartProduct->setQuantity(1);

        $this->cartProducts->add($cartProduct);
    }

    public function removeProduct(Product $product): void
    {
        foreach ($this->cartProducts as $cartProduct) {
            if ($cartProduct->getProduct() === $product) {
                if ($cartProduct->getQuantity() > 1) {
                    $cartProduct->decreaseQuantity();
                } else {
                    $this->cartProducts->removeElement($cartProduct);
                }

                return;
            }
        }
    }
}