<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneFormType;
use PhpParser\Node\Stmt\Return_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    /**
     * @Route("/add-personne", name="add_personne")
     */
    public function addPersonne(Request $request): Response
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneFormType::class, $personne);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personne);
            $entityManager->flush();
            return $this->redirectToRoute('read_personne');
        }

        return $this->render('personne/personne-form.html.twig', [
            "form_title" => "Ajouter un personne",
            "form_product" => $form->createView(),
        ]);
    }
    /**
     * @Route("/read-personne", name="read_personne")
     */
    public function readPersonne()
    {
        $personnes = $this->getDoctrine()->getRepository(Personne::class)->findAll();

        return $this->render('personne/personnes.html.twig', [
            "personnes" => $personnes,
        ]);
    }
    /**
     * @Route ("/modify-personne/{id}", name="modify_personne")
     */
    public function modifyPersonne(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $personne = $entityManager->getRepository(Personne::class)->find($id);
        $form = $this->createForm(PersonneFormType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('read_personne');
        }
        return $this->render("personne/personne-form.html.twig", [
            "form_title" => "Modifier un personne",
            "form_product" => $form->createView(),
        ]);
    }
    /**
     * @Route("/delete-personne/{id}", name="delete_personne")
     */
    public function deletePersonne(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $personne = $entityManager->getRepository(Personne::class)->find($id);
        $entityManager->remove($personne);
        $entityManager->flush();

        return $this->redirectToRoute('read_personne');
    }
    /**
     * @Route("/personne", name="liste_personne")
     */
    public function listePersonne()
    {
        $personnes = $this->getDoctrine()->getRepository(Personne::class)->getListePersonne();
        return $this->render("personne/personnes.html.twig", [
            "personnes" => $personnes,
        ]);
    }
}
