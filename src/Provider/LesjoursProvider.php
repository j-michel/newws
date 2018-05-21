<?php

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class LesjoursProvider extends BaseProvider
{
  protected function getItemDescription($item)
  {
    $crawler = new Crawler($item->getDescription());

    return $crawler->filter('p')->first()->text();
  }

  protected function getPublishedAt($item)
  {
    return $item->getLastModified();
  }

  protected function getItemCoverUrl($item)
  {
    $client = new Client();

    $crawler = $client->request('GET', $item->getLink());

    return $crawler->filterXPath("//meta[@property='og:image']")->first()->attr('content');
  }

  protected function getIsFree($item)
  {
    return false;
  }
}
