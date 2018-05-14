<?php

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;

class LabasProvider extends BaseProvider
{
  protected function getItemDescription($item)
  {
    $crawler = new Crawler($item->getDescription());

    return $crawler->filter('p')->count() > 0 ? strip_tags($crawler->filter('p')->first()->html()) : '';
  }

  protected function getItemCoverUrl($item)
  {
    foreach ($item->getAllElements() as $element) {

      if($element->getName() == "media:content"){

        return $element->getAttribute('url');
      }
    }

    return 'toto';
  }
}
