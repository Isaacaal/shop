<?php

namespace App\Controller\Front\Product;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produits', name: 'app_products_')]
class ProductController extends AbstractController
{
    #[Route('/', name:'list')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_home');
    }

    #[Route('/{slug}', name: 'show', requirements: ['slug' => '[a-z0-9\-]+'])]
    public function show(Product $product): Response
    {
        return $this->render('front/products/show.html.twig', [
            'product' => $product,
        ]);
    }
}