<?php

// Entité Category créé: php bin/console make:entity
// création automatique de mon entité Category et de son repository
//  Ensuite, je fais: php bin/console make:migration qui permet de faire la migration
// et ça créait une version dans migrations, j'envoie ça dans ma BDD avec: php bin/console make:migration:migrate
// j'ai ajouté les données "manuellement" dans ma BDD

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    //je défini la route pour afficher toutes les categories

    #[Route(path :'/categories', name: 'categories')]
    //je fais un autowire de category repository pour interroger ma BDD
    public function showAllCategories(CategoryRepository $categoryRepository)
    {
        //je fais un dump("yep");die;

        //je crée une variable categories qui sont les catégories trouvées dans ma BDD et ses colonnes
        $categories = $categoryRepository->findAll();
        return $this->render('categories.html.twig', ['categories' => $categories]);
    }

    #[Route(path: '/category/{id}', name:'category_show', requirements:['id' => '\d+'])]
    public function getCategoryById(CategoryRepository $categoryRepository, int $id)
    {
        $categoryFound = $categoryRepository->find($id);

        if ($categoryFound === null) {
            return $this->render('category_show.html.twig', ['category' => $categoryFound]);

        } else
            return $this->redirectToRoute('error_404.html.twig');
    }
}