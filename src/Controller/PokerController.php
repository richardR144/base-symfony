<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokerController extends AbstractController
{
    // je définie la route avec l'URL qui est suivi de /poker
    //je lui donne le nom "poker"
    #[Route('/poker', name: 'poker')]
    public function poker()
    {
        //appel de la methode createFromGloblal de la class Request
        // sans avoir besoin d'instancier une nouvelle class Request
        //et ça grace au double points ::
        //la class Request avec sa methode createFromGlobals permet de stocker
        //les infos en POST, GET, emails, etc
        $request = Request::createFromGlobals();
        //je récupère ma variable age à partir des infos du get de mon URL
        $age = $request->query->get('age');

        if ($age >= 18){
            return $this->render('pokerAgeLegal.html.twig');
        }else {
            return $this->render('pokerAgeNonLegal.html.twig');
        }
    }
}

//Ou class PokerController
//{
//
//    #[Route('/poker', 'poker')]
//    public function poker()
//    {
//        $request = Request::createFromGlobals();
//        $age = $request->query->get('age');
//
//        $message = "";
//
//        if ($age >= 18) {
//            $message = "Tu peux accéder à la table de Poker";
//        } else {
//            $message = "Tu peux partir";
//        }
//
//        return $this->render('poker.html.twig', [
//            'message' => $message
//        ]);
//
//    }
//
//}