<?php

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class HumaniteProvider extends BaseProvider
{

  protected function getItemDescription($item)
  {
    $crawler = new Crawler($item->getDescription());

    return $crawler->filter('p')->count() > 0 ? $crawler->filter('p')->first()->text() : $crawler->filter('div')->first()->text();
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
}
