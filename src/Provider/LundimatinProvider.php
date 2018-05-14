<?php

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;

class LundimatinProvider extends BaseProvider
{
  protected function getItemDescription($item)
  {
    $crawler = new Crawler($item->getDescription());

    return $crawler->filter('p')->first()->text();
  }

  protected function getItemCoverUrl($item)
  {
    foreach ($item->getAllElements() as $element) {

      if($element->getName() == "content:encoded"){

        $crawler = new Crawler($element->getValue());

        return $crawler->filter('img')->first()->attr('src');
      }
    }
  }
}
