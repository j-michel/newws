<?php

namespace App\Provider;

use FeedIo\Factory;

class BaseProvider
{

  private $id;
  private $name;
  private $feed;
  private $url;

  public function __construct($id, $providerData)
  {
      $this->id   = $id;
      $this->name = $providerData['name'];
      $this->feed = $providerData['feed'];
      $this->url = $providerData['url'];
  }

  public function getNewArticles()
  {
    $items    = $this->getFeedItems();
    $articles = array();

    foreach ($items as $item) {
        $articles[] = array(
          'title'       => $this->getItemTitle($item),
          'description' => $this->getItemDescription($item),
          'url'         => $this->getItemLink($item),
          'coverUrl'    => $this->getItemCoverUrl($item),
          'author'      => $this->getAuthor($item),
          'publishedAt' => $this->getPublishedAt($item),
        );
    }

    return $articles;
  }

  protected function getFeedItems()
  {
    return Factory::create()->getFeedIo()->read($this->feed)->getFeed();
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
    return "https://placeimg.com/640/480/people";
  }

  protected function getAuthor($item)
  {
    return $item->getAuthor() ? $item->getAuthor()->getName() : "";
  }

  protected function getPublishedAt($item)
  {
    foreach ($item->getAllElements() as $element) {

      if($element->getName() == "dc:date"){

        return new \DateTime($element->getValue());
      }
    }    
  }
}
