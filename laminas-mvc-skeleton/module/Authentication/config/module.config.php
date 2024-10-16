<?php

use Authentication\Controller\AuthenticationController;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use EnseignantEnseignement\Modele\factory\EnseignantFactory;
use EnseignantEnseignement\Modele\factory\EnseignementFactory;
use EnseignantEnseignement\Modele\factory\RoleFactory;
use EnseignantEnseignement\Modele\factory\StatutFactory;
use EnseignantEnseignement\Modele\Table\EnseignantTable;
use EnseignantEnseignement\Modele\Table\EnseignementTable;
use EnseignantEnseignement\Modele\Table\RoleTable;
use EnseignantEnseignement\Modele\Table\StatutTable;
use Laminas\Router\Http\Segment;
use Session\Model\Session;
return [

    "controllers"=>[
        "factories"=>[
            AuthenticationController::class =>ReflectionBasedAbstractFactory::class
        ]
    ],

    'router' => [
        'routes' => [
            'Authentication' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/auth[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => AuthenticationController::class,
                        'action'     => 'login',
                    ],
                ],
            ],       
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'authentication' => __DIR__ . '/../view',
        ],
        //ViewJsonStrategy permet d'annoncer a laminas que les renvoie json son autorisé
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],

    // on définie toute les facories pour que laminas instancie les controllers avec leurs dépendence 
    "service_manager" => [
        "factories" => [
            \Laminas\Authentication\AuthenticationService::class => function($container) {
                return new \Laminas\Authentication\AuthenticationService();
            },
            EnseignantTable::class => EnseignantFactory::class,
            EnseignementTable::class => EnseignementFactory::class,
            RoleTable::class => RoleFactory::class,
            StatutTable::class => StatutFactory::class,

        ],
    ]


];