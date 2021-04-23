<?php

namespace App\Controller;

use App\Entity\ProblemeMateriel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        dd($a);

        for(int )

        //dd($problemes);
        //$probleme->g
        //return $this->render("probleme/probleme.html.twig", [
          //  "problemes" => $problemes,
       //]);
    }
}
