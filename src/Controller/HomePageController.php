<?php

namespace App\Controller;

use App\Entity\Crud;
use App\Form\CrudType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function homePage(): Response
    {
        return $this->render('home_page/homePage.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }
    #[Route('/create', name: 'app_create_form')]
    public function creat(Request $request): Response
    {
        $crud = new Crud();
        $form = $this->createForm(CrudType::class, $crud);
        $form->handleRequest($request);

        return $this->render('form/createForm.html.twig', [
            'controller_name' => 'HomePageController',
            'form' => $form->createView()
        ]);
    }
}
