<?php

namespace App\Controller\Api;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ProductApiController extends AbstractController
{
    #[Route('/products', name: 'api_products', methods: ['GET'])]
    public function index(ProductRepository $repo): JsonResponse
    {
        $data = array_map(fn($p) => [
            'id' => $p->getId(),
            'name' => $p->getName(),
            'description' => $p->getDescription(),
            'price' => $p->getPrice(),
            'slug' => $p->getSlug(),
            'image' => $p->getImage(),
        ], $repo->findAll());

        return $this->json($data);
    }
}