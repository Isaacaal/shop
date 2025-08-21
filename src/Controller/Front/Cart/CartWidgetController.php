<?php

namespace App\Controller\Front\Cart;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartWidgetController extends AbstractController
{
    #[Route('/_cart/widget', name: 'cart_widget')]
    public function header(CartService $cart): Response
    {
        return $this->render('front/_layout/_cart_widget.html.twig', [
            'count' => $cart->count(),
        ]);
    }
}