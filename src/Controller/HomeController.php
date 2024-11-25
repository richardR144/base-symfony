<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

        //Je créai une classe HomeController
class HomeController extends AbstractController
{
    #[Route('/', 'home')]
        //Je crai une méthode home qui retourne une instance de la classe Response(symfony)
        //La classe permet une réponse HTTP valide avec un status
        //et prend en parametre le HTML à envoyer au navigateur
        //#Anotation que php prend en charge
        public function home() {
        return new Response(content:'<h1>Page d\'accueil</h1>');
    }
}