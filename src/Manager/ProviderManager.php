<?php

namespace App\Manager;

use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;

class ProviderManager
{

      private $providers;

      public function __construct(FileLocator $fileLocator)
      {
          $this->fileLocator = $fileLocator;

          $providersFile =  $this->fileLocator->locate('providers.yml', null, false);

          $this->providers = Yaml::parse(file_get_contents($providersFile[0]));
      }

      public function getAll()
      {
        return $this->providers['providers'];
      }

      public function getOne($id)
      {
        return $this->providers['providers'][$id];
      }

      public function getProviderClass($id)
      {
        $providerName = 'App\Provider\\' . ucfirst($id) . 'Provider';

        return new $providerName($id, $this->getOne($id));
      }
}
