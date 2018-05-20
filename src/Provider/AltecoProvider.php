<?php

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class AltecoProvider extends BaseProvider
{
  protected function getItemDescription($item)
  {
    $client = new Client();

    $crawler = $client->request('GET', $item->getLink());

    return $crawler->filterXPath("//meta[@name='description']")->first()->attr('content');
  }

  protected function getPublishedAt($item)
  {
    return $item->getLastModified();
  }

  protected function getItemCoverUrl($item)
  {
    $client = new Client();

    $crawler = $client->request('GET', $item->getLink());

    $nodes = $crawler->filterXPath("//meta[@property='og:image']");

    return $nodes->count() > 0 ? $nodes->first()->attr('content') : null;
  }
}
