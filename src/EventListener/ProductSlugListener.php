<?php

namespace App\EventListener;

use App\Entity\Product;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductSlugListener
{
    public function __construct(
        private SluggerInterface $slugger
    ) {}

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof Product) {
            return;
        }

        $this->setSlug($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof Product) {
            return;
        }

        $this->setSlug($entity);
    }

    private function setSlug(Product $product): void
    {
        if (!$product->getName()) {
            return;
        }

        $slug = $this->slugger->slug($product->getName(), '-')->toString();
        $slug = preg_replace('/[^a-zA-Z0-9\-]+/', '-', $slug);
        $slug = strtolower($slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        $product->setSlug($slug);
    }
}
