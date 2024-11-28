<?php

// Entité Category créé: php bin/console make:entity
// création automatique de mon entité Category et de son repository
//  Ensuite, je fais: php bin/console make:migration qui permet de faire la migration
// et ça créait une version dans migrations, j'envoie ça dans ma BDD avec: php bin/console make:migration:migrate
// j'ai ajouté les données "manuellement" dans ma BDD

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    //je défini la route pour afficher toutes les categories

    #[Route(path :'/categories', name: 'categories_list')]
    //je fais un autowire de category repository pour interroger ma BDD
    public function listCategories(CategoryRepository $categoryRepository):Response
    {
        //je fais un dump("yep");die;

        //je crée une variable categories qui sont les catégories trouvées dans ma BDD et ses colonnes
        $categories = $categoryRepository->findAll();
        return $this->render('categories_list.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route(path: '/category/{id}', name:'show_category', requirements:['id' => '\d+'])]
    public function showCategory(int $id, CategoryRepository $categoryRepository )
    {
        $categoryFound = $categoryRepository->find($id);


            return $this->render('category_show.html.twig', [
                'category' => $categoryFound
            ]);
    }
#[Route('/categories/create', 'create_category')]
    public function createCategory(EntityManagerInterface $entityManager)
    {
        $category = new Category();

        // l'id est généré automatiquement par la BDD, du coup, inutile de le déclarer
        //je créais avec les setters les categories par le title et color
        $category->setTitle( 'category 1');
        $category->setColor( 'red');
        //je pré-sauvegarde mes entity
        $entityManager->persist($category);
        //On réunit le tout pour l'afficher
        $entityManager->flush();
        //et je le redirige vers la liste des catégories pour plus de sens
        return $this->redirectToRoute('categories_list.html.twig');
    }

}