<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(array $data): bool
    {
        $email = new Email();

        try {
            $email
                ->from($data['email'])
                ->to('larsa_lamont@hotmail.fr')
                ->subject('Contact for Information :')
                ->html($this->buildEmailBody($data));

            $this->mailer->send($email);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function buildEmailBody(array $data): string
    {
        $emailBody = sprintf(
            "<h3>New Contact Form Submission</h3>
            <p><strong>Nom:</strong> %s</p>
            <p><strong>Prenom:</strong> %s</p>
            <p><strong>Email:</strong> %s</p>
            <p><strong>Phone:</strong> %s</p>
            <p><strong>Message:</strong> %s</p>",
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['phone'],
            $data['message']
        );

        foreach (['modele', 'prix', 'nomProprietaire', 'prenomProprietaire'] as $key) {
            if (!empty($data[$key])) {
                $emailBody .= sprintf("<p><strong>%s:</strong> %s</p>", ucfirst($key), $data[$key]);
            }
        }

        return $emailBody;
    }
}