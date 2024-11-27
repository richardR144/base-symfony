<?php
namespace App\Controller;


use App\Repository\ArticleRepository;
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
    public function articleSearchResults(Request $request) {

        $search = $request->query->get('search');
        return $this->render('article_search_results.html.twig', [
            'search' => $search
        ]);

    }
}

