<?php

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class ThinkerviewProvider extends BaseProvider
{

  protected function getItemTitle($item)
  {
    return strpos($item->getTitle(), 'EN DIRECT') == false ? $item->getTitle() : substr($item->getTitle(), 0 , strlen($item->getTitle()) - 11);
  }

  protected function getItemDescription($item)
  {
    return "";
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
