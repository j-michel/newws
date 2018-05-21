<?php

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class AsiProvider extends BaseProvider
{

  protected function getItemDescription($item)
  {
    $client = new Client();

    $crawler = $client->request('GET', $item->getLink());

    return $crawler->filterXPath("//meta[@property='og:title']")->first()->attr('content');
  }

  protected function getItemCoverUrl($item)
  {
    $client = new Client();

    $crawler = $client->request('GET', $item->getLink());

    return $crawler->filterXPath("//meta[@property='og:image']")->first()->attr('content');
  }

  protected function getPublishedAt($item)
  {
    return $item->getLastModified();
  }

  protected function getIsFree($item)
  {
    $client = new Client();

    $crawler = $client->request('GET', $item->getLink());

    return $crawler->filterXPath("//meta[@itemprop='articleSection']")->first()->attr('content') == 'chronique' ? true : false;
  }
}
