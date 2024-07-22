<?php

namespace App\Controller\Front;

use App\DTO\ContactDTO;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/front/contact', name: 'front_contact_')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ContactDTO $contact,Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success','Message envoyé !');

            $email = new Email();
            $email->from($contact->getEmail())
            ->to($contact->getService())
            ->subject('Nouveau message de contact')
            ->text($contact->getMessage());

            $mailer->send($email);
        }

        return $this->render('front/contact/index.html.twig',['formContact'=>$form]);
    }
}
