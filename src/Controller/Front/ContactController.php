<?php

namespace App\Controller\Front;

use App\DTO\ContactDTO;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/front/contact', name: 'front_contact_')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('front/contact/index.html.twig');
    }

    #[Route('/create', name: 'create')]
    public function create(ContactDTO $contact,Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success','Message envoyé !');

            return $this->redirectToRoute('front_contact_index');
        }

        return $this->render('front/contact/contact.html.twig',['formContact'=>$form]);
    }
}
