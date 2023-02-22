<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\RegistrationConfirmationEmailSender;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class RegistrationConfirmationEmailSenderTest extends TestCase
{
    public function testSendEmail(): void
    {
        $emailTo = 'test@example.com';
        $emailFrom = 'noreply@example.com';

        $templatedEmail = new TemplatedEmail();
        $templatedEmail
            ->from($emailFrom)
            ->to($emailTo)
            ->subject('Confirmation')
            ->htmlTemplate('email_confirmation.html.twig');

        $mailer = $this->createMock(MailerInterface::class);
        $mailer
            ->expects($this->once())
            ->method('send')
            ->with($this->equalTo($templatedEmail));

        $emailSender = new RegistrationConfirmationEmailSender($mailer, $emailFrom);
        $emailSender->sendEmail($emailTo);
    }

    public function testSendEmailThrowsException(): void
    {
        $emailTo = 'test@example.com';
        $emailFrom = 'noreply@example.com';

        $mailer = $this->createMock(MailerInterface::class);
        $mailer
            ->expects($this->once())
            ->method('send')
            ->willThrowException($this->createMock(TransportExceptionInterface::class));

        $emailSender = new RegistrationConfirmationEmailSender($mailer, $emailFrom);

        $this->expectException(TransportExceptionInterface::class);

        $emailSender->sendEmail($emailTo);
    }
}
