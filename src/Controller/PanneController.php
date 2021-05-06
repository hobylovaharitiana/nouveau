<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Entity\Panne;
use App\Entity\Personne;
use App\Entity\ProblemeMateriel;
use App\Form\PanneFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanneController extends AbstractController
{
    /**
     * @Route("/add-panne", name="add_panne")
     */
    public function addPanne(Request $request, EntityManagerInterface $entityManager ): Response
    {
        $panne = new Panne();
        $problemeMateriel = new ProblemeMateriel();
        $form = $this->createForm(PanneFormType::class, $panne);
        $form->handleRequest($request);

        $personnes = $entityManager->getRepository(Personne::class)->findTechnicien();
        //dd($personnes);
        $personne = $request->request->get('personnes');

        if ($form->isSubmitted() && $form->isValid())
        {
             $person = $entityManager->getRepository(Personne::class)->find((int)$personne);
             dd($person);
             $panne->setPersonnes($person);
             $entityManager->persist($panne);
            // $entityManager = $this->getDoctrine()->getManager();
             //$entityManager->persist($panne);
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
        /*return $this->render('panne/panne-form.html.twig', [
            "form_title" => "Ajouter un panne",
            "form" => $form->createView(),
            'personnes' => $personnes,
        ]);*/

        return $this->render('panne/modal.html.twig', [
            "form_title" => "Ajouter un panne",
            "form" => $form->createView(),
            'personnes' => $personnes,
        ]);
    }
    /**
     * @Route("/read-panne", name="read_panne")
     */
    public function readPanne(Request $request, EntityManagerInterface $entityManager)
    {
        $panne = new Panne();
        $problemeMateriel = new ProblemeMateriel();


        $personnes = $entityManager->getRepository(Personne::class)->findTechnicien();
        //dd($personnes);
        $personne = $request->request->get('personne');
        //dd($personne);

        $materiels = $entityManager->getRepository(Materiel::class)->findMateriel();
        //dd($materiels);
        $materiel = $request->request->get('materiel');

        $pannes = $this->getDoctrine()->getRepository(Panne::class)->findAll();
        //dd($pannes);
        $form = $this->createForm(PanneFormType::class, $panne);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            //dd($request);
            $person = $entityManager->getRepository(Personne::class)->find((int)$personne);
            $panne->setPersonnes($person);
            $entityManager->persist($panne);
            // $entityManager = $this->getDoctrine()->getManager();
            //$entityManager->persist($panne);

            $mat = $entityManager->getRepository(Materiel::class)->find((int)$materiel);
            $panne->setMateriel($mat);
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

        return $this->render('panne/pannes.html.twig', [
            "pannes" => $pannes,
            "form_title" => "Ajouter un panne",
            "form" => $form->createView(),
            'personnes' => $personnes,
            'materiels' => $materiels,
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
        //dd($panne->getPersonnes()->getId());

        $personnes = $entityManager->getRepository(Personne::class)->findTechnicien();
        $pers = $entityManager->getRepository(Personne::class)->find($panne->getPersonnes()->getId());
       // dd($pers);

        $materiels = $entityManager->getRepository(Materiel::class)->findMateriel();
        $mat = $entityManager->getRepository(Materiel::class)->find($panne->getMateriel()->getId());
        //dd($mat);

        $form = $this->createForm(PanneFormType::class, $panne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            //dd($request);
           $idPersonne = $request->get('personne');
           // dd($idPersonne);
           $newPersonne = $entityManager->getRepository(Personne::class)->find($idPersonne);
          // dd($newPersonne);
           $panne->setPersonnes($newPersonne);
            //dd($panne);

            $idMateriel = $request->get('materiel');
            //dd($idMateriel);
            $newMateriel = $entityManager->getRepository(Materiel::class)->find($idMateriel);
            //dd($newMateriel);
            $panne->setMateriel($newMateriel);
            $entityManager->flush();
            return $this->redirectToRoute('read_panne');
        }
        return $this->render("panne/panne-form.html.twig", [
            "form_title" => "Modifier un panne",
            "form" => $form->createView(),
            "personnes" => $personnes,
            "pers" => $pers,
            "mat" => $mat,
            "materiels" => $materiels,
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
