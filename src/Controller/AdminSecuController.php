<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminSecuController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription", methods="GET|POST")
     */
    public function index(Request $request, EntityManagerInterface $emi, UserPasswordEncoderInterface $encoder): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(InscriptionType::class, $utilisateur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $utilisateur->setPassword($encoder->encodePassword($utilisateur, $utilisateur->getPassword()));
            $emi->persist($utilisateur);
            $emi->flush();
            return $this->redirectToRoute('aliments');
        }

        return $this->render('admin_secu/inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="connexion", methods="GET|POST")
     */
    public function login(AuthenticationUtils $utils): Response
    {
        return $this->render('admin_secu/login.html.twig', [
            'lastUserName' => $utils->getLastUsername(),
            'error' => $utils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/logout", name="deconnexion")
     */
    public function logout()
    {
        
    }
}
