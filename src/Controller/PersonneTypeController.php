<?php

namespace App\Controller;

use App\Entity\PersonneType;
use App\Form\PersonneTypeFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneTypeController extends AbstractController
{
    /**
     * @Route("/add-personneType", name="add_personneType")
     */
    public function addPersonneType(Request $request): Response
    {
        $personneType = new PersonneType();
        $form = $this->createForm(PersonneTypeFormType::class, $personneType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personneType);
            $entityManager->flush();
            return $this->redirectToRoute('read_personneType');
        }
        return $this->render('personne_type/personnetype-form.html.twig', [
            "form_title" => "Ajouter un type de personne",
            "form_personneType" => $form->createView(),
        ]);
    }
    /**
     * @Route("/read-personneType", name="read_personneType")
     */
    public function readPersonneType()
    {
        $personneTypes = $this->getDoctrine()->getRepository(PersonneType::class)->findAll();

        return $this->render('personne_type/personnetypes.html.twig', [
            "personneTypes" => $personneTypes,
        ]);
    }
    /**
     * @Route("/personneType/{id}", name="personneType")
     */
    public function personneType(int $id): Response
    {
        $personneType = $this->getDoctrine()->getRepository(PersonneType::class)->find($id);

        $this->render($this->render("personne_type/personnetype.html.twig", [
            "personneType" => $personneType,
        ]));
    }
    /**
     * @Route("/modify-personneType/{id}", name="modify_personneType")
     */
    public function modifyPersonneType(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $personneType = $entityManager->getRepository(PersonneType::class)->find($id);
        $form = $this->createForm(PersonneTypeFormType::class, $personneType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('read_personneType');
        }
        return $this->render("personne_type/personnetype-form.html.twig", [
            "form_title" => "Modifier un type de personne",
            "form_personneType" => $form->createView(),
            ]);
    }
    /**
     * @Route("/delete-personneType/{id}", name="delete_personneType")
     */
    public function deletePersonneType(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $personneType = $entityManager->getRepository(PersonneType::class)->find($id);
        $entityManager->remove($personneType);
        $entityManager->flush();

        return $this->redirectToRoute("read_personneType");
    }
}
