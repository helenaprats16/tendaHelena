<?php
namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Seccio;

use App\Entity\Article;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/articles', name: 'article_')]
class ArticleController extends AbstractController
{

    public function __construct(private EntityManagerInterface $gestor)
    {
        $this->repositori = $this->gestor->getRepository(Article::class);
        $this->repositoriSeccio = $this->gestor->getRepository(Seccio::class);

    }

    //Mètode per crear articles
    #[Route(path: '/crear', name: 'crear', methods: ['GET', 'POST'])]
    public function crear()
    {
        try {

            $seccioRoba = $this -> repositoriSeccio -> find(1);

            $article1 = new Article();
            $article1->setNom("collar");
            $article1->setPreu(15.4);
            $article1->setStock(13);
            $article1->setImatge("img.jpg");
            $article1->setSeccio($seccioRoba);

             $article2 = new Article();
            $article2->setNom("Pendientes");
            $article2->setPreu(45.20);
            $article2->setStock(3);
            $article2->setImatge("img2.jpg");
            $article2->setSeccio($seccioRoba);
            // Indiquem que volem guardar aquest objecte
            $this->gestor->persist($article1);
            $this->gestor->persist($article2);


            // S’executa la inserció
            $this->gestor->flush();

            return $this -> render('article/afegir.html.twig',[
            'detall' => "S'ha creat el article correctament",
            'message' => " Els articles ".$article1->getNom(). " y ".$article2->getNom(). " s'ha creat correctament",
            'article' => $article1,
            'article2' => $article2 //per pasar tambe la variable article a la plantilla i poder mostrar el nom de la variable, el preu...

            ]);
        } catch (Exception $e) {
             return $this -> render('article/error.html.twig',[
            'detall' => "Error al crear l'article",
            'message' => $e ->getMessage()
            ]);
        }
    }


}