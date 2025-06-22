<?php

namespace App\Tests\Functional\Controller\Catalog\EditController;

use App\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class EditControllerFixture extends AbstractFixture
{
    public const PRODUCT_ID = '0d46b18e-4620-4519-8640-e62ef81b92ec';

    public function load(ObjectManager $manager): void
    {
        $createdAt = new \DateTimeImmutable('2025-06-21 12:00:00');

        $product = new Product(self::PRODUCT_ID, 'Product to edit', 1990, $createdAt);
        $manager->persist($product);
        $manager->flush();
    }
}
