<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    #[Route('/articles', 'articles_list')]
    public function articles()
    {

        $articles = [
            [
                'id' => 1,
                'title' => 'Article 1',
                'content' => 'Content of article 1',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 2,
                'title' => 'Article 2',
                'content' => 'Content of article 2',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 3,
                'title' => 'Article 3',
                'content' => 'Content of article 3',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 4,
                'title' => 'Article 4',
                'content' => 'Content of article 4',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 5,
                'title' => 'Article 5',
                'content' => 'Content of article 5',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ]

        ];

        return $this->render('articles_list.html.twig', [
            'articles' => $articles
        ]);

    }
    //je défini une url avec une varible id, cad que le router matchera toutes les urls
    //qui ont cette forme "/article/quelque chose", "article/5" numéro de l'article recherché
    #[Route('/showArticle/{id}', 'showArticle')]
        public function article_show($id)
    {

        $articles = [
            [
                'id' => 1,
                'title' => 'Article 1',
                'content' => 'Content of article 1',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 2,
                'title' => 'Article 2',
                'content' => 'Content of article 2',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 3,
                'title' => 'Article 3',
                'content' => 'Content of article 3',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 4,
                'title' => 'Article 4',
                'content' => 'Content of article 4',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 5,
                'title' => 'Article 5',
                'content' => 'Content of article 5',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ]

        ];
        //Je créai un variable qui doit contenir l'article trouvé à null
        $articleFound = null;
        //pour chaque article de la liste trové, je check si son id correspond à l'id récupérer de l'url
        // et si c'est bon je le stocke dans ma variable $articleFound
        foreach ($articles as $article) {
            if ($article['id'] === (int) $id) {
                $articleFound = $article;
            }
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



    }
}

