<?php

namespace App\Service;

interface EmailSender
{
    public function sendEmail(string $emailTo): void;
}
