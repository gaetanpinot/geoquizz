<?php

namespace Geoquizz\Mailer\infra\mailer;

interface MailerInterface
{
    public function send(string $senderEmail, string $targetMail, string $subject, string $body): void;
}
