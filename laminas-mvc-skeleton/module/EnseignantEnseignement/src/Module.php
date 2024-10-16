<?php
/**
 * 
 * class pour que laminas récupère les inforamtion sur le module
 * 
 */


namespace EnseignantEnseignement;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface{


    
    /**
     * Cette methode permet a Laminas de récupéré la configuration du module
     *  @return array
     */
    public function getConfig():array{

        /** @var array */
        $config = include __DIR__."/../config/module.config.php";

        return $config;

    }

}