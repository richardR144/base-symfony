<?php
namespace App\Controller;


use App\Entity\Article;
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
    public function createArticle(EntityManagerInterface $entityManager): Response
    {
        // je créé une instance de l'entité Article, car c'est elle qui représente les articles dans mon application
        $article = new Article();
        // j'utilise les méthodes set pour remplir les propriétés de mon article
        $article->setTitle(title: 'Article 2');
        $article->setContent(content: 'contenu Article 2');
        $article->setImage("https://cdn.futura-sciences.com/sources/images/dossier/773/01-intro-773.jpg");
        $article->setCreatedAt(new \DateTime());
        // La variable $article contient une instance de la classe Article avec les données voulues
        //(sauf l'id car il sera généré par la BDD)

        // j'utilise l'instance de la classe EntityManager. C'est cette classe qui permet de sauver ou supprimer
        // des entités en BDD.
        // L'entity manager et Doctrine savent que l'entité correspond à la table article et que la propriété title
        // correspond à la colonne title grâce aux annotations.
        // L'entity manager sait comment faire correspondre mon instance d'entité à un enregistrement dans ma table
        $entityManager->persist($article);
        // -persist permet de pre-sauvegarder mes entités
        // -flush éxecute la requête SQL dans ma BDD et du coup,
        // -Création d'un enregistrement d'article dans la table
        $entityManager->flush();
        return $this->render('articles_list.html.twig');
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

    #[Route('/articles/update/{id}', 'update_article', requirements: ['id' => '\d+'])]
    public function updateArticle(int $id, ArticleRepository $articleRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        //je récupère mon article de la BDD par l'id
        $article = $articleRepository->find($id);
        //je modifie la valeur des propriétés title, content
        $article->setTitle(title: 'Article 1 MAJ');
        $article->setContent(content: 'contenu Article 1 MAJ');
        //je pré-sauvegarde l'article, doctrine le MAJ
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->render('articles_update.html.twig', [
            'article' => $article
        ]);
    }
}


