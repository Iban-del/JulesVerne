<?php

namespace EnseignantEnseignement\Modele\factory;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use EnseignantEnseignement\Modele\Table\EnseignantTable;
use Laminas\Db\TableGateway\TableGateway;
use EnseignantEnseignement\Modele\Entity\Enseignant;

/**
 * EnseignantFactory
 * 
 * factory pour récupéré la EnseignementTable
 * 
 */
class EnseignantFactory implements FactoryInterface{

    /**
     * __invoke
     * 
     * récupération d'une instance de EnseignementTable 
     * 
     * @param ContainerInterface
     * 
     * @return EnseignantTable
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null):EnseignantTable
    {
        //récupération d'un instance de l'adapter dans le container
        $dbAdapter = $container->get(AdapterInterface::class);

        //récupération d'un instance de ResultSet et on lui instantie Enseignant pour qu'il nous renvoie un Enseignant
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Enseignant());

        //instanciation de TableGateway
        $tableGateway = new TableGateway('enseignant', $dbAdapter, null, $resultSetPrototype);
        return new EnseignantTable($tableGateway);

    }

}