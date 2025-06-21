<?php

namespace App\Controller\Cart;

use App\Entity\Cart;
use App\Entity\Product;
use App\Messenger\AddProductToCart;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\ResponseBuilder\ErrorBuilder;
use App\ResponseBuilder\QueuedBuilder;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart/{cart}/{product}", methods={"PUT"}, name="cart-add-product")
 */
class AddProductController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __construct(private ErrorBuilder $errorBuilder, private QueuedBuilder $queuedBuilder) {}

    public function __invoke(Cart $cart, Product $product): Response
    {
        if ($cart->isFull()) {
            return new JsonResponse(
                $this->errorBuilder->__invoke('Cart is full.'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $operationId = Uuid::uuid4()->toString();

        $this->dispatch(new AddProductToCart($operationId, $cart->getId(), $product->getId()));

        return new JsonResponse($this->queuedBuilder->__invoke($operationId), Response::HTTP_ACCEPTED);
    }
}