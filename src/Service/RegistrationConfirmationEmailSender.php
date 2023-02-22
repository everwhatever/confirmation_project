<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class RegistrationConfirmationEmailSender implements EmailSender
{
    private MailerInterface $mailer;

    private string $emailFrom;

    public function __construct(MailerInterface $mailer, string $emailFrom)
    {
        $this->mailer = $mailer;
        $this->emailFrom = $emailFrom;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(string $emailTo): void
    {
        $email = (new TemplatedEmail())
            ->from($this->emailFrom)
            ->to($emailTo)
            ->subject('Confirmation')
            ->htmlTemplate('email_confirmation.html.twig');

        $this->mailer->send($email);
    }
}
