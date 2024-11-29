<?php
namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    #[Route('/articles', 'articles_list')]
    public function articles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->render('articles_list.html.twig', [
            'articles' => $articles
        ]);

    }
    //je défini une url avec une varible id, cad que le router matchera toutes les urls
    //qui ont cette forme "/article/quelque chose", "article/5" numéro de l'article recherché
    #[Route('/showArticle/{id}', 'showArticle', requirements: ['id' => '\d'])]
    public function article_show(int $id, ArticleRepository $articleRepository): Response
    {
        $articleFound = $articleRepository->find($id);

        if (!$articleFound) {
            return $this->redirectToRoute('not_found');
        }
        //je créai une réponse HTTP contenant le HTML de mon fichier twig
        //pour ce faire, j'utilise la méthode render de l'abstract controller qui prend en param le twig
        //et en second le tableau contenant les variables utilisables dans le twig
        return $this->render('article_show.html.twig', [
            'article' => $articleFound
        ]);
    }

    #[Route('/articles/search-results', 'article_search_results')]
    // je peux utiliser le système d'instanciation automatiquement de Symfony
        // du coup, je lui passe en paramètre le type de la méthode de la classe voulue
        // suivie d'une variable dans laquelle je veux que symfony stocke l'instance
        // de la classe. Ce mécanisme est appelé: "autowire"
    public function articleSearchResults(Request $request)
    {

        $search = $request->query->get('search');
        return $this->render('article_search_results.html.twig', [
            'search' => $search
        ]);
    }

    #[Route('/articles/create', 'article_create')]
    public function createArticle(EntityManagerInterface $entityManager, Request $request): Response
    {
        $article = new Article();
            //j'utilise la méthode createForm de l'abstractController pour générer un formulaire
            //pour le nouvel article(ArticleType fait par "php bin/console make:form"
        $form = $this->createForm(ArticleType::class, $article);
            //je récupère les données de ma requête et ça les mets dans mon instance d'articles (handleReques

            $form->handleRequest($request);
            //je vérifie que mes données ont été envoyé et validé
            if ($form->isSubmitted() && $form->isValid()) {
                //je ne veux pas que l'utilisateur choisisse de mettre sa date de creation
                $article->setCreatedAt(new \DateTime());
                //j'enregistre mon entité article
                $entityManager->persist($article);
                $entityManager->flush();
            }
                $formView = $form->createView();

            return $this->render('article_create.html.twig', [
                'formView' => $formView
        ]);
    }

    #[Route('/articles/delete/{id}', 'delete_article', requirements: ['id' => '\d+'])]
    public function removeArticle(int $id, EntityManagerInterface $entityManager, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->find($id);
        if (!$article) {
            return $this->redirectToRoute('not_found');
        }

        $entityManager->remove($article);
        $entityManager->flush();

        return $this->render('article_delete.html.twig');
    }

    #[Route('/article/update/{id}', 'update_article',  ['id' => '\d+'])]
    public function updateArticle(int $id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager, Request $request)
    {
       //j'instancie $article par id
        $article = $articleRepository->find($id);

        $message = "Veuillez remplir les champs";


        // si c'est une requête POST
        if ($request->isMethod('POST')) {

            $title = $request->request->get('title');
            $content = $request->request->get('content');
            $image = $request->request->get('image');
            //Je modifie l'instance
            $article->setTitle($title);
            $article->setContent($content);
            $article->setImage($image);

            // je MAJ l'article en BDD
            $entityManager->persist($article);
            $entityManager->flush();
            //je pose un message
            $message = "L'article '" . $article->getTitle() . "' a bien été mis à jour";
        }


            return $this->render('article_update.html.twig', [
                'article' => $article,
                'message' => $message
        ]);
    }

}


