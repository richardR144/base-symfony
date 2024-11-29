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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    //je défini la route pour afficher toutes les categories

    #[Route(path: '/categories', name: 'categories_list')]
    //je fais un autowire de category repository pour interroger ma BDD
    public function listCategories(CategoryRepository $categoryRepository): Response
    {
        //je fais un dump("yep");die;

        //je crée une variable categories qui sont les catégories trouvées dans ma BDD et ses colonnes
        $categories = $categoryRepository->findAll();
        return $this->render('categories_list.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route(path: '/category/{id}', name: 'show_category', requirements: ['id' => '\d+'])]
    public function showCategory(int $id, CategoryRepository $categoryRepository)
    {
        $categoryFound = $categoryRepository->find($id);


        return $this->render('category_show.html.twig', [
            'category' => $categoryFound
        ]);
    }

    #[Route('/categories/create', 'create_category', [], ['GET', 'POST'])]
    public function createCategory(EntityManagerInterface $entityManager, Request $request): Response
    {
        $message = "Merci de remplir les champs";

        if ($request->isMethod('POST')) {
            $titleFormUser = $request->request->get('title');
            $colorFormUser = $request->request->get('color');

            $category = new Category();

            $category->setTitle($titleFormUser);
            $category->setColor($colorFormUser);

            $entityManager->persist($category);
            $entityManager->flush();

            $message = "Categorie '" . $category->getTitle() . "' créée";



        }
            return $this->render('category_create.html.twig', [
                'message' => $message
            ]);

    }


    #[Route('/category/delete/{id}/', 'delete_category')]
        public function removeCategory(int $id, EntityManagerInterface $entityManager, CategoryRepository  $categoryRepository): Response
    {
        //je récupère la catégorie que je veux suppimer et le trouver par l'id
        //si la catégory est trouvée alors je redirige ma route
            $categoryFound = $categoryRepository->find($id);

            //j'utilise la méthode remove de l'entityManager pour supprimer la categorie
            $entityManager->remove($categoryFound);
            $entityManager->flush();
            //et retourne une réponse "category deleted avec succès"
            return $this->render('category_delete.html.twig', [
                'category' => $categoryFound
            ]);
    }
    #[Route(path:'/category/update/{id}', name: 'category_update', requirements: ['id'=>'\d+'])]
        public function updateCategory(int $id, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository) : Response
    {
        //dd("yep");

        //on cherche l'instance de Catégorie qui répond à l'id demandé
        $categoryToUpdate = $categoryRepository->find($id);
        //si elle n'exsite pas c'est un 404
        if (!$categoryToUpdate) {
            return $this->redirectToRoute('not_found');
        }
        //je change les infos de notre catégorie
        $categoryToUpdate->setTitle('News');
        $entityManager->persist($categoryToUpdate);
        $entityManager->flush();

        // on retourne une jolie page qui dit que c'est bon
        return $this->render('category_update.html.twig', ['category' => $categoryToUpdate]);
    }
}