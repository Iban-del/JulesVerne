<?php

namespace EnseignantEnseignement\Modele\factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Laminas\Db\TableGateway\TableGateway;
use EnseignantEnseignement\Modele\Table\StatutTable;
use EnseignantEnseignement\Modele\Entity\Statut;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Adapter\AdapterInterface;


class StatutFactory implements FactoryInterface{

    /**
     * __invoke
     * 
     * récupération d'une instance de StatutTable 
     * 
     * @param ContainerInterface
     * 
     * @return StatutTable
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null):StatutTable
    {
        // recupération de l'adapter de db dans le container
        $dbAdapter = $container->get(AdapterInterface::class);

        //on instancie Role dans le resultset
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Statut());

        //on instancie et renvoie StatutTable avec le TableGateway en param
        $tableGateway = new TableGateway("statut",$dbAdapter,null,);
        return new StatutTable($tableGateway);
    }

}