<?php

declare(strict_types=1);

namespace Tropa;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Tropa\Model\SetorTable;
use Laminas\Db\ResultSet\ResultSet;
use Tropa\Model\Setor;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Session\SessionManager;
use Tropa\Model\Lanterna;
use Tropa\Model\LanternaTable;

return [
    'router' => [
        'routes' => [
            'tropa' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/tropa[/:controller[/:action[/:key]]]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'aliases' => [
            'setor' => Controller\SetorController::class,
            'lanterna' => Controller\LanternaController::class
        ],
        'factories' => [
            Controller\SetorController::class => function($sm){
                $table = $sm->get(SetorTable::class);
                $sessionManager = new SessionManager();
                return new Controller\SetorController($table, $sessionManager);
            },
            Controller\LanternaController::class => function($sm){
                $table = $sm->get(LanternaTable::class);
                $parentTable = $sm->get(SetorTable::class);
                $sessionManager = new SessionManager();
                return new Controller\LanternaController($table, $parentTable, $sessionManager);
            }
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
            'tropa/index/index' => __DIR__ . '/../view/tropa/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
            'factories' => [
                LanternaTable::class =>  function($sm) {
                    $tableGateway = $sm->get('LanternaTableGateway');
                    $table = new LanternaTable($tableGateway);
                    return $table;
                },
                'LanternaTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('LaminasDbAdapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Lanterna());
                    return new TableGateway('lanterna', $dbAdapter, null, $resultSetPrototype);
                },
                SetorTable::class =>  function($sm) {
                    $tableGateway = $sm->get('SetorTableGateway');
                    $table = new SetorTable($tableGateway);
                    return $table;
                },
                'SetorTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('LaminasDbAdapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Setor());
                    return new TableGateway('setor', $dbAdapter, null, $resultSetPrototype);
                },
            ],
    ]    
];
