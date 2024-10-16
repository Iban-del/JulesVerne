<?php

namespace EnseignantEnseignement\Modele\factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Laminas\Db\TableGateway\TableGateway;
use EnseignantEnseignement\Modele\Table\RoleTable;
use EnseignantEnseignement\Modele\Entity\Role;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Adapter\AdapterInterface;


class RoleFactory implements FactoryInterface{

    /**
     * __invoke
     * 
     * récupération d'une instance de RoleTable 
     * 
     * @param ContainerInterface
     * 
     * @return RoleTable
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null):RoleTable
    {
        // recupération de l'adapter de db dans le container
        $dbAdapter = $container->get(AdapterInterface::class);

        //on instancie Role dans le resultset
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Role());

        //on instancie et renvoie RoleTable avec le TableGateway en param
        $tableGateway = new TableGateway("role",$dbAdapter,null,);
        return new RoleTable($tableGateway);
    }

}