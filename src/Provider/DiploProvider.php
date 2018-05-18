<?php

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class DiploProvider extends BaseProvider
{

  protected function getItemDescription($item)
  {
    $end = strpos($item->getDescription(), '(...)');

    return substr($item->getDescription(), 0 , $end) . ' ...';
  }

  protected function getItemCoverUrl($item)
  {
    $client = new Client();

    $crawler = $client->request('GET', $item->getLink());

    return $crawler->filterXPath("//meta[@property='og:image']")->first()->attr('content');
  }
}
