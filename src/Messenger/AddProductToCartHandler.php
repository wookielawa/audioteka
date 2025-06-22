<?php

namespace App\Messenger;

use App\Service\Cart\CartServiceInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddProductToCartHandler implements MessageHandlerInterface
{
    public function __construct(private CartServiceInterface $service) { }

    public function __invoke(AddProductToCart $command): void
    {
        $this->service->addProduct($command->operationId, $command->cartId, $command->productId);
    }
}