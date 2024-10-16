<?php

namespace Authentication;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface{

    public function getConfig()
    {
        /** @var array */
        $config = include __DIR__."/../config/module.config.php";

        return $config;
    }

}