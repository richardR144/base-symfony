<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

    class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact', methods: ['GET', 'POST'])]
    public function contact(Request $request): Response
    {
        $messageSend = null;
        $message = "Merci de remplir le formulaire pour continuer";

        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $message = $request->request->get('message');
            $messageSend = "merci $name message envoyé" ;
        }
        return $this->render('contact.html.twig',
            ['messageSend' => $messageSend,]);

    }

}