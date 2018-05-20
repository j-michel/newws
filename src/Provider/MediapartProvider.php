<?php

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class MediapartProvider extends BaseProvider
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

    return $crawler->filterXPath("//meta[@property='og:image']")->first()->attr('content');
  }

}
