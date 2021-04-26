<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminSecuController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription", methods="GET|POST")
     */
    public function index(Request $request, EntityManagerInterface $emi): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(InscriptionType::class, $utilisateur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $emi->persist($utilisateur);
            $emi->flush();
            return $this->redirectToRoute('aliments');
        }

        return $this->render('admin_secu/inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
