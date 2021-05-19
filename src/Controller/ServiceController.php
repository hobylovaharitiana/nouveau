<?php

namespace App\Controller;

use App\Entity\Service;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/read-service", name="read_service")
     */
    public function services(Request $request, PaginatorInterface $paginator)
    {

        $ser = $this->getDoctrine()->getRepository(Service::class)->findAll();
        $services = $paginator->paginate(
            $ser,
            $request->query->getInt('page', 1),3
        );
        return $this->render('service/services.html.twig', [
            'services' => $services,
        ]);
    }
    /**
     * @Route("/service/{id}", name="service")
     */
    public function service(int $id): Response
    {
        $service = $this->getDoctrine()->getRepository(Service::class)->find($id);

        return $this->render("service/service.html.twig", [
            "service" => $service,
        ]);
    }
}
