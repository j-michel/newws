<?php

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;


class AcrimedProvider extends BaseProvider
{

  protected function getItemDescription($item)
  {
    $crawler = new Crawler($item->getDescription());

    return $crawler->filter('p')->first()->text();
  }

}
