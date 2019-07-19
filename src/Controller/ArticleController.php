<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/new", name="article_create")
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            foreach($article->getImages() as $image){
                $image->setArticle($article);
                $manager->persist($image);
            }

            $manager->persist($article);
            $manager->flush();

            $this->addFlash('success', "L'article <strong>{$article->getTitle()}</strong> a bien été enregistré");

            return $this->redirectToRoute('article_show', [
                'slug' => $article->getSlug()
            ]);
        }

        return $this->render('article/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/{slug}/edit", name="article_edit")
     * 
     * @return Response
     */
    public function edit(Article $article, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            foreach($article->getImages() as $image){
                $image->setArticle($article);
                $manager->persist($image);
            }

            $manager->persist($article);
            $manager->flush();

            $this->addFlash('success', "L'article <strong>{$article->getTitle()}</strong> a bien été enregistré");

            return $this->redirectToRoute('article_show', [
                'slug' => $article->getSlug()
            ]);
        }

        return $this->render('article/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/{page?1}", name="article_index")
     */
    public function index(ArticleRepository $repo, $page)
    {
        $limit = 6;

        $start = $page * $limit - $limit;

        $total = count($repo->findAll());

        $pages = ceil($total / $limit);
        
        return $this->render('article/index.html.twig', [
            'paginate' => $pages,
            'articles' => $repo->findBy([], [], $limit, $start),
            'page' => $page
        ]);
    }

    /**
     * @Route("/article/show/{slug}", name="article_show")
     */
    public function show( Article $article )
    {
        #$ad = $repo->findOneBySlug($slug);
        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }
}
