<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Goutte\Client;

class ExtractCommand extends Command
{

    protected function configure()
    {
      $this
          // the name of the command (the part after "bin/console")
          ->setName('app:extract')

          // the short description shown while running "php bin/console list"
          ->setDescription('Extract something :)')
      ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

      // outputs a message followed by a "\n"
      $output->writeln('EXTRACT TITLE !!!');

      $client = new Client();

      $crawler = $client->request('GET', 'https://lundi.am');

      $output->writeln($crawler->filter('title')->first()->text());

      $output->writeln('EXTRACT RSS !!!');

      // create a simple FeedIo instance
      $feedIo = \FeedIo\Factory::create()->getFeedIo();

      // read a feed
      $result = $feedIo->read("https://lundi.am/spip.php?page=backend");

      // iterate through items
      foreach( $result->getFeed() as $item ) {
          var_dump($item->getDescription());

          die();

      }
    }
}
