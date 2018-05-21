<?php

namespace App\Provider;

use FeedIo\Factory;

class BaseProvider
{

  private $id;
  private $name;
  private $feeds;
  private $url;

  public function __construct($id, $providerData)
  {
      $this->id    = $id;
      $this->name  = $providerData['name'];
      $this->feeds = $providerData['feeds'];
      $this->url   = $providerData['url'];
  }

  public function getNewArticles()
  {
    $results = $this->getFeedItems();
    $articles = array();

    foreach ($results as $items) {
      foreach ($items as $item) {
          $articles[] = array(
            'title'       => $this->getItemTitle($item),
            'description' => $this->getItemDescription($item),
            'url'         => $this->getItemLink($item),
            'coverUrl'    => $this->getItemCoverUrl($item),
            'author'      => $this->getAuthor($item),
            'publishedAt' => $this->getPublishedAt($item),
            'isFree'      => $this->getIsFree($item),
            'provider'    => $this->id
          );
      }
    }

    return $articles;
  }

  protected function getFeedItems()
  {
    $yesterday = new \DateTime('-3 days');
    $feedIo = Factory::create()->getFeedIo();
    $results = array();

    foreach ($this->feeds as $feed) {
      $results[] = $feedIo->read($feed, null, $yesterday)->getFeed();
    }

    return $results;
  }

  protected function getItemTitle($item)
  {
    return $item->getTitle();
  }

  protected function getItemDescription($item)
  {
    return $item->getDescription();
  }

  protected function getItemLink($item)
  {
    return $item->getLink();
  }

  protected function getItemCoverUrl($item)
  {
    return null;
  }

  protected function getAuthor($item)
  {
    return $item->getAuthor() ? $item->getAuthor()->getName() : null;
  }

  protected function getPublishedAt($item)
  {
    foreach ($item->getAllElements() as $element) {

      if($element->getName() == "dc:date"){

        return new \DateTime($element->getValue());
      }
    }
  }

  protected function getIsFree($item)
  {
    return true;
  }
}
