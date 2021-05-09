<?php

namespace App\Controller;

use App\Entity\ProblemeMateriel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

class ProblemeController extends AbstractController
{
    /**
     * @Route("/probleme", name="liste_probleme")
     */
    public function listeProbleme()
    {
        $probleme = new ProblemeMateriel();
        $problemes = $this->getDoctrine()->getRepository(ProblemeMateriel::class)->getListeProbleme();
        $nombrepanne = $this->getDoctrine()->getRepository(ProblemeMateriel::class)->getNombrePanne();
        $a = sizeof($nombrepanne);
        //dd($a);


        $nombrepanne = [];
        $nomMateriel = [];
        $comptes = 0;

            foreach ($problemes as $probleme){
                //satry nombrePanne tode direct fa ts anat accollade n 0 (voir postman)
                $nombrepanne[$comptes] = $probleme['nombrePanne'];
                $nomMateriel[$comptes] = $probleme["0"]['materiel']['nomMateriel'];
                //var_dump($nomMateriel[$comptes]);

                $comptes++;
            }
        //return new JsonResponse($problemes); (hijerena n form de mapiasa postman)
        //return new JsonResponse($problemes);

        //dd($problemes);
        //$probleme->g
        return $this->render("probleme/probleme.html.twig", [
            "nombrepanne" => $nombrepanne, "nomMateriel" => $nomMateriel, "comptes" => $comptes -1
       ]);
    }
}
