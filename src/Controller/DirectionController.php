<?php

namespace App\Controller;

use App\Entity\Direction;
use App\Form\DirectionFormType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DirectionController extends AbstractController
{
    /**
     * @Route("/add-direction", name="add_direction")
     */
    public function addDirection(Request $request): Response
    {
        $direction = new Direction();
        $form = $this->createForm(DirectionFormType::class, $direction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($direction);
            $entityManager->flush();
            return $this->redirectToRoute("read_direction");
        }
        return $this->render("direction/direction-form.html.twig", [
            "form_title" => "Ajouter un direction",
            "form_direction" => $form->createView(),
        ]);
    }

    /**
     * @Route("/read-direction", name="read_direction")
     */
    public function directions(PaginatorInterface $paginator, Request $request)
    {
        $dir = $this->getDoctrine()->getRepository(Direction::class)->findAll();
        $directions = $paginator->paginate(
            $dir,
            $request->query->getInt('page', 1),3
        );
        return $this->render('direction/directions.html.twig', [
            "directions" => $directions,
        ]);
    }

    /**
     * @Route("/direction/{id}", name="direction")
     */
    public function direction(int $id): Response
    {
        $direction = $this->getDoctrine()->getRepository(Direction::class)->find($id);

        return $this->render("direction/direction.html.twig", [
            "direction" => $direction,
        ]);
    }
}
