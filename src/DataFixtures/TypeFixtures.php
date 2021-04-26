<?php

namespace App\DataFixtures;

use App\Entity\Type;
use App\Entity\Aliment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $type = new Type();
        $type->setLibelle('Légumes')
            ->setImage('legumes.jpg');
        $manager->persist($type);

        $type2 = new Type();
        $type2->setLibelle('Fruits')
            ->setImage('fruits.jpg');
        $manager->persist($type2);

        $repo = $manager->getRepository(Aliment::class);
        
        $a1 = $repo->findOneBy(['nom' => 'Carotte']);
        $a1->setType($type);
        $manager->persist($a1);

        $a2 = $repo->findOneBy(['nom' => 'Patate']);
        $a2->setType($type);
        $manager->persist($a2);

        $a3 = $repo->findOneBy(['nom' => 'Pomme']);
        $a3->setType($type2);
        $manager->persist($a3);

        $a4 = $repo->findOneBy(['nom' => 'Tomate']);
        $a4->setType($type2);
        $manager->persist($a4);

        $manager->flush();
    }
}
