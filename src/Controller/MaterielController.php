<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Entity\Panne;
use App\Entity\Personne;
use App\Entity\ProblemeMateriel;
use App\Form\MaterielFormType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
    public function addMateriel(Request $request, EntityManagerInterface  $entityManager): Response
    {
        $materiel = new Materiel();
        $form = $this->createForm(MaterielFormType::class, $materiel);
        $form->handleRequest($request);

        $personnes = $entityManager->getRepository(Personne::class)->findUtilisateur();
       // dd($personnes);
        $personne = $request->request->get('personne');
        if ($form->isSubmitted() && $form->isValid()) {

            //maka objet(fitambaran momban personne)     #variable
            $person = $entityManager->getRepository(Personne::class)->find((int)$personne);
            //dd($person);
            $materiel->setPersonnes($person);
            $entityManager->persist($materiel);
            $entityManager->flush();

            return $this->redirectToRoute('read_materiel');
        }
        /*return $this->render('materiel/materiel-form.html.twig', [
           "form_title" => "Ajouter un materiel",
           "form" => $form->createView(),

            "personnes" => $personnes,
        ]);*/
        return $this->render("materiel/modal.html.twig", [
            "form_title" => "Ajouter un materiel",
            "form" => $form->createView(),

            "personnes" => $personnes,
        ]);

    }
    /**
     * @Route("/read-materiel", name="read_materiel")
     */
    public function readMateriel( EntityManagerInterface  $entityManager, Request $request, PaginatorInterface $paginator)
    {

        $pa = $request->request->get('search');
       // dd($pa);

        $materiel = new Materiel();
        $form = $this->createForm(MaterielFormType::class, $materiel);
        $form->handleRequest($request);

        $personnes = $entityManager->getRepository(Personne::class)->findUtilisateur();
        // dd($personnes);
        $personne = $request->request->get('personne');
        if ($form->isSubmitted() && $form->isValid()) {

            //maka objet(fitambaran momban personne)     #variable
            $person = $entityManager->getRepository(Personne::class)->find((int)$personne);
            //dd($person);
            $materiel->setPersonnes($person);
            $entityManager->persist($materiel);
            $entityManager->flush();

            return $this->redirectToRoute('read_materiel');
        }
        $listPt = $this->getDoctrine()->getRepository(Personne::class)->findTechnicien();
        if ($pa == ''){
            $mat = $this->getDoctrine()->getRepository(Materiel::class)->findAll();
        }
        else{
            $mat = $this->getDoctrine()->getRepository(Materiel::class)->searchByName($pa);
        }

        $materiels = $paginator->paginate(
            $mat,
            $request->query->getInt('page', 1),5
        );



        return $this->render('materiel/materiels.html.twig', [
           "listPt" => $listPt,
           "materiels" => $materiels,
            "form_title" => "Ajouter un materiel",
            "form" => $form->createView(),
            "personnes" => $personnes,
        ]);

        $idMax = $this->getDoctrine()->getRepository(Personne::class)->getLastPanne();
        //dd($idMax);
        $personne = $this->getDoctrine()->getRepository(Personne::class)->findOneBy($idMax);
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
        //dd($materiel->getPersonnes()->getId());

        //dd($materiel->get);

        $personnes = $entityManager->getRepository(Personne::class)->findUtilisateur();

        $pers = $entityManager->getRepository(Personne::class)->find($materiel->getPersonnes()->getId());

        //dd($pers);

        $form = $this->createForm(MaterielFormType::class, $materiel);
        //stocker anat $request n zvtr nmodifiena rht
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid())
        {
            //dd($request);
            $idPersonne = $request->get('personne');
            //dd($idPersonne);
            $newPersonne = $entityManager->getRepository(Personne::class)->find($idPersonne);
            //dd($newPersonne);
            //set = mandefa
            $materiel->setPersonnes($newPersonne);
            //dd($materiel);
            $entityManager->flush();
            return $this->redirectToRoute('read_materiel');

        }
        return $this->render("materiel/materiel-form.html.twig", [
            "form_title" => "Modifier un materiel",
            "form" => $form->createView(),
            "personnes" => $personnes,
            "pers" => $pers,
        ]);


    }
    /**
     *@Route("/edit-materiel", name="edit_materiel")
     */
    public function editMateriel(Request $request){
        $nomMateriel = $request->request->get('nomMateriel');
        $marqueMateriel = $request->request->get('marqueMateriel');
        $caracteristique = $request->request->get('caracteristique');
        $personne = $request->request->get('personne');
        $materiel = $this->getDoctrine()->getRepository(Materiel::class)->find((int)$request->request->get('idMateriel'));
        $materiel->setNomMateriel($nomMateriel);
        $materiel->setMarqueMateriel($marqueMateriel);
        $materiel->setCaracteristique($caracteristique);
        $personne = $this->getDoctrine()->getRepository(Personne::class)->find((int)$request->request->get('personne'));
        $materiel->setPersonnes($personne);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('read_materiel');


    }


    /**
     * @Route("/delete-materiel/{id}", name="delete_materiel")
     */
    public function deleteMateriel(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $materiel = $entityManager->getRepository(Materiel::class)->find($id);
        $panne = $entityManager->getRepository(Panne::class)->findPanneByMateriel($id);
        $probleme = $entityManager->getRepository(ProblemeMateriel::class)->findProblemeByMateriel($id);

    if ($panne == null && $probleme == null){
        $entityManager->remove($materiel);
        $entityManager->flush();

        return $this->redirectToRoute("read_materiel");
    }
    else{
        return $this->redirectToRoute('read_materiel');
       }
    }
    }

