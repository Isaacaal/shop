<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            ['Laptop Pro 15"', "Un ordinateur portable puissant pour le travail et le gaming.", 1299.99],
            ['Smartphone X200', "Un smartphone dernier cri avec un excellent appareil photo.", 899.90],
            ['Casque Audio HD', "Casque sans fil avec réduction de bruit active.", 199.99],
            ['Souris Gamer RGB', "Souris ergonomique avec 7 boutons programmables.", 59.99],
            ['Clavier Mécanique', "Clavier mécanique rétro-éclairé, switches bleus.", 89.90],
            ['Écran 27" 4K', "Moniteur UHD avec HDR pour une qualité d’image optimale.", 349.00],
            ['Chaise de bureau', "Chaise ergonomique avec support lombaire réglable.", 149.90],
            ['Tablette Graphique', "Idéale pour le dessin numérique et la retouche photo.", 229.99],
            ['Montre Connectée', "Montre avec suivi du sommeil et des activités sportives.", 179.99],
            ['Enceinte Bluetooth', "Enceinte portable étanche avec basses puissantes.", 99.00],
            ['Webcam Full HD', "Parfaite pour les visioconférences et le streaming.", 59.00],
            ['Imprimante Laser', "Imprimante rapide et économique en noir et blanc.", 199.00],
        ];

        foreach ($products as [$name, $description, $price]) {
            $product = new Product();
            $product->setName($name);
            $product->setDescription($description);
            $product->setPrice($price);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
