<?php

namespace App\Controller;

use App\Repository\AlimentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlimentController extends AbstractController
{
    /**
     * @Route("/", name="aliments")
     */
    public function index(AlimentRepository $repo): Response
    {
        return $this->render('aliment/index.html.twig', [
            'aliments' => $repo->findAll(),
            'isGlucide' => false,
            'isCalorie' => false
        ]);
    }

    /**
     * @Route("/aliments/calorie/{calorie}", name="alimentsParCalorie")
     */
    public function afficherAlimentParCalorie(AlimentRepository $repo, $calorie): Response
    {
        return $this->render('aliment/index.html.twig', [
            'aliments' => $repo->afficherAlimentParPropriete('calorie', '<', $calorie),
            'isCalorie' => true,
            'isGlucide' => false,
            'nb' => $calorie
        ]);
    }

    /**
     * @Route("/aliments/glucide/{glucide}", name="alimentsParGlucide")
     */
    public function afficherAlimentParPropriete(AlimentRepository $repo, $glucide): Response
    {
        return $this->render('aliment/index.html.twig', [
            'aliments' => $repo->afficherAlimentParPropriete('glucide', '<', $glucide),
            'isGlucide' => true,
            'isCalorie' => false,
            'nb' => $glucide
        ]);
    }
}
