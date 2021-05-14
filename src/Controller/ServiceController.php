<?php

namespace App\Controller;

use App\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/read-service", name="read_service")
     */
    public function services()
    {
        $services = $this->getDoctrine()->getRepository(Service::class)->findAll();
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
