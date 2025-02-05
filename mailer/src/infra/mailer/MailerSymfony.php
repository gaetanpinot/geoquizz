<?php

namespace Geoquizz\Mailer\infra\mailer;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class MailerSymfony implements MailerInterface
{
    private Mailer $mailer;
    public function __construct(string $dsn)
    {
        $transport =  Transport::fromDsn($dsn);
        $this->mailer = new Mailer($transport);
    }

    public function send(string $senderEmail, string $targetMail, string $subject, string $body): void
    {
        $mail = (new Email())
            ->from($senderEmail)
            ->to($targetMail)
            ->subject($subject)
            ->text($body);
        $this->mailer->send($mail);
    }
}
