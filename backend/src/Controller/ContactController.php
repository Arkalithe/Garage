<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\MailerService;

class ContactController extends AbstractController
{
    private MailerService $mailerService;

    public function __construct(MailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }


    #[Route("/contact", name: "contact", methods: ["POST"])]
    public function sendEmail(Request $request): Response
    {
        $data = $request->request->all();
        $emailSent = $this->mailerService->sendEmail($data);

        if ($emailSent) {
            return $this->json([
                'message' => 'Email Envoyer avec succée !',
            ], 200);
        }

        return $this->json([
            'message' => 'Probleme envoie du mail.',
        ], 400);
    }
}