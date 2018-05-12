<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Article;

class MainController extends Controller
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Article::class);

        $articles = $repository->findAll();


        return $this->render('main/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
