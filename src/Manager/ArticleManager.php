<?php

namespace App\Manager;

use App\Repository\ArticleRepository;
use App\Entity\Article;

class ArticleManager
{
      private $articleRepository;

      public function __construct(ArticleRepository $articleRepository)
      {
          $this->articleRepository = $articleRepository;
      }

      public function saveNewArticles($articles){
        foreach ($articles as $article) {
          if($this->isNew($article['url'])){
              $this->create($article);
          }
        }
      }

      public function create($data)
      {
        $article = new Article();

        $article->setTitle($data['title']);
        $article->setDescription($data['description']);
        $article->setUrl($data['url']);
        $article->setCoverUrl($data['coverUrl']);
        $article->setProvider($data['provider']);
        $article->setPublishedAt($data['publishedAt']);

        $this->articleRepository->save($article);
      }

      public function isNew($url)
      {
          return $this->articleRepository->countByUrl($url) == 0 ? true: false;
      }
}
