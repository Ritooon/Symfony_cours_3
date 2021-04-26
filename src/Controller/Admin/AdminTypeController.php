<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTypeController extends AbstractController
{
    /**
     * @Route("/admin/type", name="admin_types")
     */
    public function index(TypeRepository $repo): Response
    {
        return $this->render('admin/admin_type/admin_type.html.twig', [
            'types' => $repo->findAll(),
        ]);
    }

    /**
     * @Route("/admin/type/create", name="ajout_type")
     * @Route("/admin/type/{id}", name="modif_type", methods="GET|POST")
     */
    public function ajoutModificationType(Type $type = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$type)
        {
            $type = new Type();
        }

        $isModif = $type->getId() !== null;
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($type);
            $entityManager->flush();
            $this->addFlash('success', ($isModif) ? "La modification a été réalisée" : "Le type a bien été ajouté");
            return $this->redirectToRoute('admin_types');
        }

        return $this->render('admin/admin_type/ajout_modif.html.twig', [
            'type' => $type,
            'isModification' => $isModif,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/type/{id}", name="supprimer_type", methods="DEL")
     */
    public function suppressionType(Type $type, EntityManagerInterface $entityManager, Request $request): Response
    {
        if($this->isCsrfTokenValid('DEL'.$type->getId(), $request->get('_token')))
        {
            $entityManager->remove($type);
            $entityManager->flush();
            $this->addFlash('success', "La suppresion a été effectuée");
            return $this->redirectToRoute('admin_types');
        }                
    }
}
