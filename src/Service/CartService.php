<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductRepository;

class CartService
{
    private SessionInterface $session;

    public function __construct(
        RequestStack $requestStack,
        private ProductRepository $products
    ) {
        $this->session = $requestStack->getSession();
    }

    private function cart(): array
    {
        return $this->session->get('cart', []);
    }

    private function save(array $cart): void
    {
        $this->session->set('cart', $cart);
    }

    public function add(int $id, int $qty = 1): void
    {
        $cart = $this->cart();
        $cart[$id] = ($cart[$id] ?? 0) + max(1, $qty);
        $this->save($cart);
    }

    public function set(int $id, int $qty): void
    {
        $cart = $this->cart();
        if ($qty <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id] = $qty;
        }
        $this->save($cart);
    }

    public function remove(int $id): void
    {
        $cart = $this->cart();
        unset($cart[$id]);
        $this->save($cart);
    }

    public function clear(): void
    {
        $this->session->remove('cart');
    }

    public function count(): int
    {
        return array_sum($this->cart());
    }

    public function items(): array
    {
        $data = [];
        foreach ($this->cart() as $id => $qty) {
            if ($p = $this->products->find($id)) {
                $data[] = [
                    'product'  => $p,
                    'quantity' => $qty,
                    'subtotal' => $p->getPrice() * $qty
                ];
            }
        }
        return $data;
    }

    public function total(): float
    {
        return array_sum(array_column($this->items(), 'subtotal'));
    }
}
