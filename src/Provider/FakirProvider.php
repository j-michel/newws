<?php

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;

class FakirProvider extends BaseProvider
{
  protected function getItemDescription($item)
  {
    $crawler = new Crawler($item->getDescription());

    return $crawler->filter('p')->first()->text();
  }
}
