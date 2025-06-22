<?php

namespace App\Tests\Integration\Service;

use App\Entity\CartAddProductStatus;
use App\Service\Cart\CartServiceInterface;
use App\Tests\Integration\KernelTestCase;

class CartServiceTest extends KernelTestCase
{
    private CartServiceInterface $cartService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures(new AddProductToTheCartFixture());

        $this->cartService = static::getContainer()->get(CartServiceInterface::class);
    }

    public function test_refuses_to_add_fourth_product_to_cart(): void
    {
        $operationId = '66939eef-8af6-466b-a87f-52c6379e5873';
        $cartId = '1e82de36-23f3-4ae7-ad5d-616295f1d6c0';
        $productId = '9670ea5b-d940-4593-a2ac-4589be784203';

        $this->cartService->addProduct($operationId, $cartId, $productId);

        $found = $this->entityManager->find(CartAddProductStatus::class, $operationId);

        $this->assertEquals($found->getId(), $operationId);
        $this->assertEquals($found->getMessage(), 'Cart is full.');
    }

    // more tests that cover the whole repository
}