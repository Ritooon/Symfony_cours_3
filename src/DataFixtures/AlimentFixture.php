<?php

namespace App\DataFixtures;

use App\Entity\Aliment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AlimentFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $l1 = new Aliment();
        $l1->setNom('Carotte')
            ->setCalorie(15)
            ->setGlucide(5.3)
            ->setLipide(7.2)
            ->setProteine(9)
            ->setPrix(1.29)
            ->setImage('carotte.png')
        ;
        $manager->persist($l1);

        $l2 = new Aliment();
        $l2->setNom('Patate')
            ->setCalorie(30)
            ->setGlucide(8.6)
            ->setLipide(9.1)
            ->setProteine(10.1)
            ->setPrix(2.99)
            ->setImage('patate.png')
        ;
        $manager->persist($l2);

        $l3 = new Aliment();
        $l3->setNom('Pomme')
            ->setCalorie(10)
            ->setGlucide(7)
            ->setLipide(6)
            ->setProteine(5)
            ->setPrix(4.99)
            ->setImage('pomme.png')
        ;
        $manager->persist($l3);

        $l4 = new Aliment();
        $l4->setNom('Tomate')
            ->setCalorie(13)
            ->setGlucide(6)
            ->setLipide(7)
            ->setProteine(4)
            ->setPrix(2.95)
            ->setImage('tomate.png')
        ;
        $manager->persist($l4);

        $manager->flush();
    }
}
