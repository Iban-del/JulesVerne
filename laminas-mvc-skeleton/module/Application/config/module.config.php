<?php

declare(strict_types=1);

namespace Application;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use EnseignantEnseignement\Modele\factory\EnseignantFactory;
use EnseignantEnseignement\Modele\factory\EnseignementFactory;
use EnseignantEnseignement\Modele\factory\RoleFactory;
use EnseignantEnseignement\Modele\factory\StatutFactory;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use EnseignantEnseignement\Modele\Table\EnseignantTable;
use EnseignantEnseignement\Modele\Table\EnseignementTable;
use EnseignantEnseignement\Modele\Table\RoleTable;
use EnseignantEnseignement\Modele\Table\StatutTable;
use EnseignantEnseignement\Modele\Filter\EnseignantFilter;
use EnseignantEnseignement\Modele\Filter\EnseignementFilter;
use EnseignantEnseignement\Modele\Filter\RoleFilter ;
use EnseignantEnseignement\Modele\Filter\StatutFilter;

return [

    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => ReflectionBasedAbstractFactory::class,
        ],
    ],
    "service-manager"=>[

        "factories"=>[
            EnseignantTable::class => EnseignantFactory::class,
            EnseignementTable::class => EnseignementFactory::class,
            RoleTable::class => RoleFactory::class,
            StatutTable::class => StatutFactory::class,
        ],
        'shared' => [
            \Session\Model\Session::class => true,
        ],

    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
           
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];
