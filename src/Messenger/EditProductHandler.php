<?php

namespace App\Messenger;

use App\Service\Catalog\Product;
use App\Service\Catalog\ProductService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class EditProductHandler implements MessageHandlerInterface
{
    public function __construct(private readonly ProductService $service) { }

    public function __invoke(EditProduct $command): Product
    {
        return $this->service->edit($command->id, $command->name, $command->price);
    }
}
