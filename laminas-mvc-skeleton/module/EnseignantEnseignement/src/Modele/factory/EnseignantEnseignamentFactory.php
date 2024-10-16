<?php

namespace EnseignantEnseignement\Modele\factory;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use EnseignantEnseignement\Modele\Table\EnseignantEnseignamentTable;
use Laminas\Db\TableGateway\TableGateway;
use EnseignantEnseignement\Modele\Entity\EnseignantEnseignement;


/**
 * permet de revoyer une instance de EnseignantEnseignamentTable
 */
class EnseignantEnseignamentFactory implements FactoryInterface{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        
        $adapter = $container->get(AdapterInterface::class);

        $resultSet = new ResultSet();

        $resultSet->setArrayObjectPrototype(new EnseignantEnseignement());
        
        $tableGateway = new TableGateway("enseignant_enseignement",$adapter,null,$resultSet);

        return new EnseignantEnseignamentTable($tableGateway);
    }

}