<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

//Je créai une classe HomeController
// et je l'étend sur l' AbstractController
class HomeController extends AbstractController
{
    #[Route('/', 'home')]
        //Je crai une méthode home qui retourne une instance de la classe Response(symfony)
        //La classe permet une réponse HTTP valide avec un status
        //et prend en parametre le HTML à envoyer au navigateur
        //#Anotation que php prend en charge
        public function home() {
        //La méthode render de la classe AbstractController et récupère le fichier twig
        //passé en paramètre dans le dossier Template, elle le convertit en html et elle
        //créait une réponse HTTP valide avec un status HTTP 200 et en body, le html généré
        return $this->render('home.html.twig');
    }
}