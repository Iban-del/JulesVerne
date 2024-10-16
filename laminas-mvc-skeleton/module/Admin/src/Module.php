<?php


namespace Admin;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface{

    /**
     * 
     * getConfig
     * 
     * Récupéré le lien vers la config 
     * Warning: ne pas oublié le include
     * 
     */
    public function getConfig()
    {
        $config = include __DIR__."/../config/module.config.php";
        return $config;
    }

}