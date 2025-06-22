<?php

declare(strict_types=1);

namespace App\Controller\Catalog;

use App\Entity\Product;
use App\Messenger\EditProduct;
use App\ResponseBuilder\ErrorBuilder;
use App\ResponseBuilder\ProductBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products/{product}", methods={"PUT"}, name="product-edit")
 */
class EditController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        private readonly ErrorBuilder $errorBuilder,
        private readonly ProductBuilder $productBuilder,
        MessageBusInterface $messageBus,
    ) {
        $this->messageBus = $messageBus;
    }

    public function __invoke(?Product $product, Request $request): Response
    {
        $name = trim($request->get('name'));
        $price = (int)$request->get('price');

        if ($name === '' || $price < 1) {
            return new JsonResponse(
                $this->errorBuilder->__invoke('Invalid name or price.'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return new JsonResponse(
            $this->productBuilder->__invoke(
                $this->handle(new EditProduct($product->getId(), $name, $price))
            ),
            Response::HTTP_OK
        );
    }
}
