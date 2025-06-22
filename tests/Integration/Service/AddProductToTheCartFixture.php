<?php

namespace App\Tests\Integration\Service;

use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class AddProductToTheCartFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $createdAt = new \DateTimeImmutable('2025-06-21 12:00:00');

        $products = [
            new Product('fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7', 'Product 1', 1990, $createdAt),
            new Product('9670ea5b-d940-4593-a2ac-4589be784203', 'Product 2', 3990, $createdAt),
        ];

        foreach ($products as $product) {
            $manager->persist($product);
        }

        $fullCart = new Cart('1e82de36-23f3-4ae7-ad5d-616295f1d6c0');
        $fullCart->addProduct($products[0]);
        $fullCart->addProduct($products[0]);
        $fullCart->addProduct($products[1]);
        $manager->persist($fullCart);

        $manager->flush();
    }
}