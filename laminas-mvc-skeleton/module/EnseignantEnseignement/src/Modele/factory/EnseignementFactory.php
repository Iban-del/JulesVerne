<?php

namespace EnseignantEnseignement\Modele\factory;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use EnseignantEnseignement\Modele\Table\EnseignementTable;
use Laminas\Db\TableGateway\TableGateway;
use EnseignantEnseignement\Modele\Entity\Enseignement;

/**
 * EnseignementFactory
 * 
 * factory pour récupéré la EnseignementTable
 * 
 */
class EnseignementFactory implements FactoryInterface{

    /**
     * __invoke
     * 
     * récupération d'une instance de EnseignementTable 
     * 
     * @param ContainerInterface
     * 
     * @return EnseignementTable
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null):EnseignementTable
    {
        //récupération d'un instance de l'adapter dans le container
        $dbAdapter = $container->get(AdapterInterface::class);

        //récupération d'un instance de ResultSet et on lui instantie Enseignement pour qu'il nous renvoie un Enseignement
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Enseignement());

        //instanciation de TableGateway
        $tableGateway = new TableGateway('enseignement', $dbAdapter, null, $resultSetPrototype);
        return new EnseignementTable($tableGateway);

    }

}