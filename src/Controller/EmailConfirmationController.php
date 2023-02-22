<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\ConfirmationType;
use App\Service\EmailSender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailConfirmationController extends AbstractController
{
    private EmailSender $emailSender;

    public function __construct(EmailSender $emailSender)
    {
        $this->emailSender = $emailSender;
    }

    /**
     * @Route("/", name="confirm_action")
     */
    public function confirmAction(Request $request): Response
    {
        $form = $this->createForm(ConfirmationType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->emailSender->sendEmail($form->get('email')->getData());

            return $this->render('thank_you.html.twig');
        }

        return $this->render('confirm_email.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
