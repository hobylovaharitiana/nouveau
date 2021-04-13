<?php

namespace App\Controller;

use App\Entity\TypePersonne;
use App\Form\TypePersonneFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypePersonneController extends AbstractController
{
    /**
     * @Route("/add-typePersonne", name="add_typePersonne")
     */
    public function addtypePersonne(Request $request ): Response
    {
        $typePersonne = new TypePersonne();
        $form = $this->createForm(TypePersonneFormType::class, $typePersonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typePersonne);
            $entityManager->flush();

            //retour a la liste
            return $this->redirectToRoute('read_typePersonne');
        }

        return $this->render('type_personne/typePersonne-form.html.twig', [
            "form_title" => "Ajouter un typePersonne",
            "form_typePersonne" => $form->createView(),
        ]);
    }
    /**
     * @Route("/read-typePersonne", name="read_typePersonne")
     */
    public function readtypePersonne()
    {
        $typePersonnes = $this->getDoctrine()->getRepository(TypePersonne::class)->findAll();

        return $this->render('type_personne/typePersonnes.html.twig', [
            "typePersonnes" => $typePersonnes,
        ]);
    }
    /**
     * @Route("/typePersonne/{id}", name="typePersonne")
     */
    public function typePersonne(int $id): Response
    {
        $typePersonne = $this->getDoctrine()->getRepository(TypePersonne::class)->find($id);

        return $this->render("typePersonne/typePersonne.html.twig", [
            "typePersonne" => $typePersonne,
        ]);
    }
    /**
     * @Route("/modify-typePersonne", name="modify_typePersonne")
     */
    public function modifytypePersonne(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $typePersonne = $entityManager->getRepository(TypePersonne::class)->find($id);
        $form = $this->createForm(TypePersonneFormType::class, $typePersonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
        }
        return $this->render("typePersonne/typePersonne-form.html.twig", [
            "form_title" => "Modifier un type",
            "form_typePersonne" => $form->createView(),
        ]);
    }
    /**
     * @Route("/modify-typePersonne/{id}", name="modify_typePersonne")
     */
    public function modifytype(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $typePersonne = $entityManager->getRepository(TypePersonne::class)->find($id);
        $form = $this->createForm(TypePersonneFormType::class, $typePersonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            //flush=ajout a la base
            $entityManager->flush();

            //retour a la liste
            return $this->redirectToRoute('read_typePersonne');
        }
        return $this->render("type_Personne/typePersonne-form.html.twig", [
            "form_title" => "Modifier un type",
            "form_typePersonne" => $form->createView()
        ]);
    }
    /**
     * @Route("/delete-typePersonne/{id}", name="delete_typePersonne")
     */
    public function deletetype(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $typePersonne = $entityManager->getRepository(TypePersonne::class)->find($id);
        $entityManager->remove($typePersonne);
        $entityManager->flush();

        return $this->redirectToRoute("read_typePersonne");
    }
}
