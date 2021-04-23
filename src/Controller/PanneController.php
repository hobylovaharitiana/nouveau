<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Entity\Panne;
use App\Entity\ProblemeMateriel;
use App\Form\PanneFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanneController extends AbstractController
{
    /**
     * @Route("/add-panne", name="add_panne")
     */
    public function addPanne(Request $request): Response
    {
        $panne = new Panne();
        $problemeMateriel = new ProblemeMateriel();
        $form = $this->createForm(PanneFormType::class, $panne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($panne);
             $entityManager->flush();

            //maka idpanne napidirina farany
            $idPanne = $this->getDoctrine()->getRepository(Panne::class)->makaIdPanne();
           // dd($idPanne);

            //maka panne ze manana anle id
            $pannes = $this->getDoctrine()->getRepository(Panne::class)->find($idPanne);
            //dd($pannes);
            $idMateriel = $pannes->getMateriel()->getid();
            //dd($idMateriel);
            $materiel = $this->getDoctrine()->getRepository(Materiel::class)->find($pannes->getMateriel()->getid());
            //dd($materiel);

            $problemeMateriel->setMateriel($materiel);
            $problemeMateriel->setPanne($pannes);
            $entityManager->persist($problemeMateriel);
            $entityManager->flush();

            return $this->redirectToRoute('read_panne');
        }
        return $this->render('panne/panne-form.html.twig', [
            "form_title" => "Ajouter un panne",
            "form_panne" => $form->createView(),
        ]);
    }
    /**
     * @Route("/read-panne", name="read_panne")
     */
    public function readPanne()
    {
        $pannes = $this->getDoctrine()->getRepository(Panne::class)->findAll();

        return $this->render('panne/pannes.html.twig', [
            "pannes" => $pannes,
        ]);
    }
    /**
     * @Route("/panne/{id}", name="panne")
     */
    public function panne(int $id): Response
    {
        $panne = $this->getDoctrine()->getRepository(Panne::class)->find($id);

        return $this->render("panne/panne.html.twig", [
            "panne" => $panne,
        ]);
    }
    /**
     * @Route("/modify-panne/{id}", name="modify_panne")
     */
    public function modifyPanne(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $panne = $entityManager->getRepository(Panne::class)->find($id);
        $form = $this->createForm(PanneFormType::class, $panne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
        }
        return $this->render("panne/panne-form.html.twig", [
            "form_title" => "Modifier un panne",
            "form_panne" => $form->createView(),
        ]);
    }
    /**
     * @Route("/delete-panne/{id}", name="delete_panne")
     */
    public function deletePanne(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $panne = $entityManager->getRepository(Panne::class)->find($id);
        $entityManager->remove($panne);
        $entityManager->flush();
        return $this->redirectToRoute("read_panne");
    }
    /**
     * @Route("/panne", name="liste_panne")
     */
    public function listePanne()
    {
        $pannes = $this->getDoctrine()->getRepository(Panne::class)->getListePanne();
        return $this->render("panne/pannes.html.twig", [
            "pannes" => $pannes,
        ]);
    }

}
