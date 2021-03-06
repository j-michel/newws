<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Manager\ArticleManager;
use App\Manager\ProviderManager;
use App\Entity\Article;
use App\Entity\Provider;

class ExtractArticlesCommand extends Command
{

    private $articleManager;
    private $providerManager;

    public function __construct(ArticleManager $articleManager, ProviderManager $providerManager)
    {
        $this->articleManager  = $articleManager;
        $this->providerManager = $providerManager;

        parent::__construct();
    }

    protected function configure()
    {
      $this->setName('app:extract:articles');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
      $output->writeln('EXTRACT ARTICLES !!!');

      $providers = $this->providerManager->getAll();

      foreach ($providers as $providerId => $providerData) {

        $provider = $this->providerManager->getProviderClass($providerId);

        $output->writeln('EXTRACT PROVIDER : ' . $providerId);

        $articles = $provider->getNewArticles();

        $this->articleManager->saveNewArticles($articles);
      }

    }
}
