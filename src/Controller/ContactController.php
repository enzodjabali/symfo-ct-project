<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\MailerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerService $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Send email
            $subject = 'Someone has reached you';
            $mailer->sendEmail(
                from: 'myself@myapp.lan',
                to: 'myself@myapp.lan',
                subject: $subject,
                htmlTemplate: 'email/contact/index.html.twig',
                
                // Context
                contactEmail: $form->get('email')->getData(),
                contactMessage: $form->get('message')->getData()
            );

            $this->addFlash(
                'success',
                'Your message has been successfully sent!'
            );

            return $this->redirectToRoute('app_contact', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
