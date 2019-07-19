<?php
namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController{
    /**
     * @Route("/", name="homepage")
     * 
     * @return void
     */
    public function home(ArticleRepository $repo){
        $articles = $repo->findAll();
        $total = count($articles);
        return $this->render('home.html.twig', [
            'total' => $total,
            'articles' => $articles
        ]);
    }
}
?>