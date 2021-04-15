<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Entity\Personne;
use App\Form\MaterielFormType;
use phpDocumentor\Reflection\DocBlock\Description;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaterielController extends AbstractController
{
    /**
     * @Route("/add-materiel", name="add_materiel")
     */
    public function addMateriel(Request $request): Response
    {
        $materiel = new Materiel();
        $form = $this->createForm(MaterielFormType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($materiel);
            $entityManager->flush();
            return $this->redirectToRoute('read_materiel');

        }
        return $this->render('materiel/materiel-form.html.twig', [
           "form_title" => "Ajouter un materiel",
           "form_materiel" => $form->createView(),
        ]);
    }
    /**
     * @Route("/read-materiel", name="read_materiel")
     */
    public function readMateriel()
    {
        $materiels = $this->getDoctrine()->getRepository(Materiel::class)->findAll();

        return $this->render('materiel/materiels.html.twig', [
            "materiels" => $materiels,
        ]);
    }
    /**
     * @Route("/materiel/{id}", name="materiel")
     */
    public function materiel(int $id): Response
    {
        $materiel = $this->getDoctrine()->getRepository(Materiel::class)->find($id);

        return $this->render("materiel/materiel.html.twig", [
            "materiel" => $materiel,
        ]);
    }
    /**
     * @Route("/modify-materiel/{id}", name="modify_materiel")
     */
    public function modifyMateriel(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $materiel = $entityManager->getRepository(Materiel::class)->find($id);
        $form = $this->createForm(MaterielFormType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('read_materiel');
        }
        return $this->render("materiel/materiel-form.html.twig", [
            "form_title" => "Modifier un materiel",
            "form_materiel" => $form->createView(),
        ]);
    }
    /**
     * @Route("/delete-materiel/{id}", name="delete_materiel")
     */
    public function deleteMateriel(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $materiel = $entityManager->getRepository(Materiel::class)->find($id);
        $entityManager->remove($materiel);
        $entityManager->flush();

        return $this->redirectToRoute("read_materiel");
    }
    /**
     * @Route("/materiel", name="liste_materiel")
     */
    public function listeMateriel()
    {
        $materiels = $this->getDoctrine()->getRepository(Materiel::class)->getMateriel();

        return $this->render("materiel/materiels.html.twig", [
            "materiels" => $materiels,
        ]);
    }
}
