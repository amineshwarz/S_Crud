<?php

namespace App\Controller;

use App\Entity\Crud;
use App\Form\CrudType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function homePage(EntityManagerInterface $entityManager): Response
    {
        $datas = $entityManager -> getRepository(Crud::class)-> findall(); 

        return $this->render('home_page/homePage.html.twig', [
            'controller_name' => 'HomePageController',
            'datas' => $datas,
        ]);
    }


    #[Route('/create', name: 'app_create_form')]
    public function creat(Request $request, EntityManagerInterface $entityManager): Response
    {
        $crud = new Crud();
        $form = $this->createForm(CrudType::class, $crud);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($crud);
            $entityManager-> flush();
            
            $this->addFlash('notice','Soumission réussi !!');
             return $this->redirectToRoute('app_home_page');
        }  

        return $this->render('form/createForm.html.twig', [
            'controller_name' => 'HomePageController',
            'form' => $form->createView(),
            
        ]);
    }


    #[Route('/edit/{id}', name: 'app_edit_form')]
    public function editForm($id ,Request $request, EntityManagerInterface $entityManager ): Response
    {
        $crud = $entityManager-> getRepository(Crud::class)->find ($id);
        $form = $this->createForm(CrudType::class, $crud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($crud);
            $entityManager-> flush();
            
            $this->addFlash('notice','Modification réussi !!');
             return $this->redirectToRoute('app_home_page');
        }  

        return $this->render('form/editForm.html.twig', [
            'controller_name' => 'HomePageController',
            'form' => $form->createView(),

        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete_page')]
    public function deleteForm( $id, EntityManagerInterface $entityManager): Response
    {
        $crud = $entityManager-> getRepository(Crud::class)->find ($id);
        
            $entityManager->remove($crud);
            $entityManager->flush();

            $this->addFlash('notice','Suppression réussi !!');
       
        return $this->redirectToRoute('app_home_page');
    }
     

}