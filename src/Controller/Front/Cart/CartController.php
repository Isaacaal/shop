<?php

namespace App\Controller\Front\Cart;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/panier', name: 'app_cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CartService $cart): Response
    {
        return $this->render('front/cart/index.html.twig', [
            'items' => $cart->items(),
            'total' => $cart->total(),
        ]);
    }

    #[Route('/add/{id}', name: 'add', methods: ['POST','GET'])]
    public function add(int $id, Request $request, CartService $cart): Response
    {
        $qty = max(1, $request->get('qty', 1));
        $cart->add($id, (int)$qty);
        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/set/{id}', name: 'set', methods: ['POST'])]
    public function setQty(int $id, Request $request, CartService $cart): Response
    {
        $cart->set($id, (int)$request->request->get('qty', 1));
        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/remove/{id}', name: 'remove', methods: ['POST','GET'])]
    public function remove(int $id, CartService $cart): Response
    {
        $cart->remove($id);
        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/clear', name: 'clear', methods: ['POST','GET'])]
    public function clear(CartService $cart): Response
    {
        $cart->clear();
        return $this->redirectToRoute('app_cart_index');
    }
}
