<?php

namespace App\Controller\Admin;

use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminAlimentController extends AbstractController
{
    /**
     * @Route("/admin/aliments", name="admin_aliments")
     */
    public function index(AlimentRepository $repo): Response
    {
        return $this->render('admin/admin_aliment/index.html.twig', [
            'aliments' => $repo->findAll(),
        ]);
    }

    /**
     * @Route("/admin/aliment/creation", name="ajout_aliment")
     * @Route("/admin/aliment/{id}", name="modification_aliment", methods="GET|POST")
     */
    public function ajoutModificationAliment(Aliment $aliment = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$aliment) 
        {
            $aliment = New Aliment();
        }

        $form = $this->createForm(AlimentType::class, $aliment);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $isModif = $aliment->getId() !== null;
            $entityManager->persist($aliment);
            $entityManager->flush();
            $this->addFlash('success', ($isModif) ? 'La modification a été effectuée' : 'L\'aliment a bien été ajouté');
            return $this->redirectToRoute('admin_aliments');
        }

        return $this->render('admin/admin_aliment/ajout_modification_aliment.html.twig', [
            'aliment' => $aliment,
            'form' => $form->createView(),
            'isModification' => $aliment->getId() !== null
        ]);
    }

     /**
     * @Route("/admin/aliment/{id}", name="suppression_aliment", methods="DEL")
     */
    public function suppressionAliment(Aliment $aliment, Request $request, EntityManagerInterface $entityManager): Response
    {
        if($this->isCsrfTokenValid('DEL'.$aliment->getId(), $request->get('_token')))
        {
            $entityManager->remove($aliment);
            $entityManager->flush();
            $this->addFlash('success', 'La suppression a été effectuée');
            return $this->redirectToRoute('admin_aliments');
        }
    }
}
