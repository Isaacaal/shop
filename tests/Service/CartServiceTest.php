<?php

namespace App\Tests\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\CartService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class CartServiceTest extends TestCase
{
    private CartService $cart;
    private Session $session;

    protected function setUp(): void
    {
        $this->session = new Session(new MockArraySessionStorage());

        $request = new Request();
        $request->setSession($this->session);

        $requestStack = new RequestStack();
        $requestStack->push($request);

        $repo = $this->createMock(ProductRepository::class);
        $repo->method('find')->willReturnCallback(function ($id) {
            $p = new Product();
            $ref = new \ReflectionProperty(Product::class, 'id');
            $ref->setAccessible(true);
            $ref->setValue($p, $id);

            return match ($id) {
                1 => $p->setName('Produit A')->setPrice(10),
                2 => $p->setName('Produit B')->setPrice(25),
                default => null,
            };
        });

        $this->cart = new CartService($requestStack, $repo);
    }

    public function testTotalIsCorrect(): void
    {
        $this->cart->add(1, 2);
        $this->cart->add(2, 1);

        $this->assertSame(45.0, $this->cart->total(), 'Le total du panier doit être 45.0');
    }

    public function testEmptyCartTotalIsZero(): void
    {
        $this->assertSame(0.0, $this->cart->total(), 'Le total d’un panier vide doit être 0.0');
    }
}
