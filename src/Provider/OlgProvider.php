<?php

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class OlgProvider extends BaseProvider
{

  protected function getItemTitle($item)
  {
    return strpos($item->getTitle(), 'Usul.') === false ? $item->getTitle() : substr($item->getTitle(), 6);
  }

  protected function getItemDescription($item)
  {
    foreach ($item->getAllElements() as $element) {

      if($element->getName() == "media:group"){

          foreach ($element->getAllElements() as $mediaElement) {
            if($mediaElement->getName() == "media:description"){
              return substr($mediaElement->getValue(), 0, strpos($mediaElement->getValue(), '☞') -1 );
            }
          }
        }
      }
      return '';
  }

  protected function getPublishedAt($item)
  {
    foreach ($item->getAllElements() as $element) {

      if($element->getName() == "published"){

        return new \DateTime($element->getValue());
      }
    }
  }

  protected function getItemCoverUrl($item)
  {
    foreach ($item->getAllElements() as $element) {

      if($element->getName() == "media:group"){

          foreach ($element->getAllElements() as $mediaElement) {
            if($mediaElement->getName() == "media:thumbnail"){

              $attributes = $mediaElement->getAttributes();
              return $attributes['url'];
            }
          }
        }
      }
      return null;
  }

  protected function getType($item)
  {
    return 'video';
  }
}
