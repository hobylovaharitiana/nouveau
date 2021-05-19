<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Entity\Panne;
use App\Entity\Personne;
use App\Entity\PersonneType;
use App\Form\PersonneFormType;
use Knp\Component\Pager\PaginatorInterface;
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

       /* return $this->render('personne/personne-form.html.twig', [
            "form_title" => "Ajouter un personne",
            "form_product" => $form->createView(),
        ]);*/
        return $this->render('personne/modal.html.twig', [
            "form_title" => "Ajouter un personne",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/read-personne", name="read_personne")
     */
    public function readPersonne(Request $request, PaginatorInterface $paginator)
    {
        $pa = $request->request->get('search');
       
        //dd($pa);
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
        $listPt = $this->getDoctrine()->getRepository(PersonneType::class)->findAll();
        if ($pa == '') {
            $pers = $this->getDoctrine()->getRepository(Personne::class)->findAll();
        }
        else {            
            $pers = $this->getDoctrine()->getRepository(Personne::class)->searchByName($pa);
        }
        

        $personnes = $paginator->paginate(
            $pers,
            $request->query->getInt('page', 1),5
        );

        $action = $request->request->get('action');
        $idPersonne = $request->request->get('idPersonne');

        //debut suppression de personne
        if ($action != null){
            $entityManager = $this->getDoctrine()->getManager();
            $personne = $entityManager->getRepository(Personne::class)->find($idPersonne);
            $materiel = $entityManager->getRepository(Materiel::class)->findMerielByPersonne($idPersonne);
            $panne = $entityManager->getRepository(Panne::class)->findPanneByPersonne($idPersonne);

            if ($materiel == null && $panne == null){
                $entityManager->remove($personne);
                $entityManager->flush();
                return $this->redirectToRoute('read_personne', [
                    "listPt" => $listPt,
                    "personnes" => $personnes,
                    "form_title" => "Ajouter un personne",
                    "form" => $form->createView(),
                    "messages" => "Personne supprime",
                ]);
            }
            else if ($materiel != null){
                return $this->render('personne/personnes.html.twig',[
                    "listPt" => $listPt,
                    "personnes" => $personnes,
                    "form_title" => "Ajouter un personne",
                    "form" => $form->createView(),
                    "messages"=>"On ne doit pas supprimer cette personne car il ocuppe un materiel",
                ]);
            }
            else if ($panne != null){
                return $this->render('personne/personnes.html.twig',[
                    "listPt" => $listPt,
                    "personnes" => $personnes,
                    "form_title" => "Ajouter un personne",
                    "form" => $form->createView(),
                    "messages"=>"On ne doit pas supprimer cette personne car il a deja deppanner un panne",
                ]);
            }
            else{
                return $this->redirectToRoute('read_personne');
            }
        }
       if ($form->isSubmitted() && $form->isValid())
       {
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($personne);
           $entityManager->flush();
           return $this->redirectToRoute('read_personne');
       }
       return $this->render('personne/personnes.html.twig', [
           "listPt" => $listPt,
           "personnes" => $personnes,
           "form_title" => "Ajouter un personne",
           "form" => $form->createView(),
           "messages"=>"",
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
     * @Route("/edit-personne", name="edit_personne")
     */
    public function editPersonne(Request $request) {
        //if($request->isMethod('POST')) {
        $nomPersonne = $request->request->get('nomPersonne');
        $prenomPersonne = $request->request->get('prenomPersonne');
        $emailPersonne = $request->request->get('emailPersonne');
        $telephone = $request->request->get('telephone');
        $adresse = $request->request->get('adresse');
        $typePersonne = $request->request->get('typePersonne');
        $personne = $this->getDoctrine()->getRepository(Personne::class)->find((int)$request->request->get('idPersonne'));
        $personne->setNomPersonne($nomPersonne);
        $personne->setPrenomPersonne($prenomPersonne);
        $personne->setEmailPersonne($emailPersonne);
        $personne->setTelephone($telephone);
        $personne->setAdresse($adresse);
        $typePers = $this->getDoctrine()->getRepository(PersonneType::class)->find((int)$request->request->get('typePersonne'));
        $personne->setPersonneType($typePers);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('read_personne');

        // }
    }

    /**
     * @Route("/delete-personne/{id}", name="delete_personne")
     */
    public function deletePersonne(int $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $personne = $entityManager->getRepository(Personne::class)->find($id);
       // dd($personne);
        $materiel = $entityManager->getRepository(Materiel::class)->findMerielByPersonne($id);
        //dd($materiel);

        $panne = $entityManager->getRepository(Panne::class)->findPanneByPersonne($id);


        if ($materiel == null && $panne == null) {
            $entityManager->remove($personne);
            $entityManager->flush();
            return $this->redirectToRoute('read_personne');
        }
        else {
            return $this->redirectToRoute('read_personne');
        }

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
