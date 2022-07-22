<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailerService
{
    public function __construct(private MailerInterface $mailer) {}

    public function sendEmail(
        string $from,
        string $to,
        string $subject,
        string $htmlTemplate,

        // TodoController
        string $todoTodo = '',
        string $todoEmail = '',
        string $todoCurrentEmail = '',

        // ContactController
        string $contactEmail = '',
        string $contactMessage = ''

        ): void
    {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            // ->text('Sending emails is fun again!')
            // ->html($content);
            ->htmlTemplate($htmlTemplate)
            ->context([
                // TodoController
                'todoTodo' => $todoTodo,
                'todoEmail' => $todoEmail,
                'todoCurrentEmail' => $todoCurrentEmail,

                // ContactController
                'contactEmail' => $contactEmail,
                'contactMessage' => $contactMessage,
            ])
        ;

        $this->mailer->send($email);

        // ...
    }
}