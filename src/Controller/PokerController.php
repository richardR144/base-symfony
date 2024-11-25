<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokerController
{
    #[Route('/poker', 'poker')]
    public function poker() {
        //appele la méthode createFormGlobals() sans avoir besoin de
        // faire l'instance de class manuellement
        //cette méthode permet de remplir la variable
        // $request (get, post, email, etc)

    $request = Request::createFromGlobals();
    $age = $request->query->get(key:'age');
    return new Response(content:'Bienvenue sur le site Poker');
    }
}