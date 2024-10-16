<?php
/**
 * 
 * fichié de configuration du module
 * 
 * controllers => permet d'instencié les controller automatiquement
 * router => definir le router
 */

use Admin\Controller\AdminController;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use EnseignantEnseignement\Modele\factory\EnseignantFactory;
use EnseignantEnseignement\Modele\factory\EnseignementFactory;
use EnseignantEnseignement\Modele\factory\RoleFactory;
use EnseignantEnseignement\Modele\factory\StatutFactory;
use EnseignantEnseignement\Modele\Table\EnseignantTable;
use EnseignantEnseignement\Modele\Table\EnseignementTable;
use EnseignantEnseignement\Modele\Table\RoleTable;
use EnseignantEnseignement\Modele\Table\StatutTable;

return [
    'controllers' => [
        'factories' => [
            AdminController::class => ReflectionBasedAbstractFactory::class,
            
        ],
    ],

    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'Admin' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/Admin[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => AdminController::class,
                        'action'     => 'index',
                    ],
                ],
            ],       
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'EnseignantEnseignement' => __DIR__ . '/../view',
        ],
        //ViewJsonStrategy permet d'annoncer a laminas que les renvoie json son autorisé
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],

    // on définie toute les facories pour que laminas instancie les controllers avec leurs dépendence 
    "service_manager" => [
        "factories" => [

            EnseignantTable::class => EnseignantFactory::class,
            EnseignementTable::class => EnseignementFactory::class,
            RoleTable::class => RoleFactory::class,
            StatutTable::class => StatutFactory::class
        ],
        
    ]
];