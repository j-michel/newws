<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Article;
use App\Manager\ProviderManager;

class MainController extends Controller
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'articles' => $this->getDoctrine()->getManager()->getRepository(Article::class)->getLasts(),
        ]);
    }

    /**
     * @Route("/articles", name="articles")
     */
    public function articles()
    {
        return $this->render('main/articles.html.twig', [
            'articles' => $this->getDoctrine()->getManager()->getRepository(Article::class)->getLastsByType('article'),
        ]);
    }

    /**
     * @Route("/videos", name="videos")
     */
    public function videos()
    {
        return $this->render('main/videos.html.twig', [
            'articles' => $this->getDoctrine()->getManager()->getRepository(Article::class)->getLastsByType('video'),
        ]);
    }

    /**
     * @Route("/sources/{id}", name="provider")
     */
    public function provider($id, ProviderManager $providerManager)
    {
        return $this->render('main/provider.html.twig', [
            'provider' => $providerManager->getOne($id),
            'articles' => $this->getDoctrine()->getManager()->getRepository(Article::class)->getLastsByProvider($id),
        ]);
    }


}
