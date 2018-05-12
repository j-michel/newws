<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use FeedIo\Factory;
use App\Entity\Article;
use App\Entity\Provider;

class ExtractArticlesCommand extends Command
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
      $this->setName('app:extract:articles');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
      $output->writeln('EXTRACT ARTICLES !!!');

      // create a simple FeedIo instance
      $feedIo = Factory::create()->getFeedIo();

      $repository = $this->entityManager->getRepository(Provider::class);

      $providers = $repository->findAll();

      foreach ($providers as $provider) {
        // read a feed
        $result = $feedIo->read($provider->getFeedUrl());

        // iterate through items
        foreach( $result->getFeed() as $item ) {


            $article = new Article();
            $article->setTitle($item->getTitle());
            $article->setUrl($item->getLink());
            $article->setProvider($provider);
            $article->setPublishedAt(new \DateTime());

            foreach ($item->getAllElements() as $element) {

              if($element->getName() == "dc:date"){

                $publishedAt = new \DateTime($element->getValue());
                $article->setPublishedAt($publishedAt);
              }
            }

            $this->entityManager->persist($article);

            $this->entityManager->flush();

        }
      }

    }
}
