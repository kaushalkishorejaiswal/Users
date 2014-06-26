<?php
return array(
    // /////End of the variable//////
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Users\Controller\User',
                        'action' => 'index'
                    )
                )
            ),
            'users' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/users[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\User',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'wildcard',
                        'options' => array(
                            'route' => 'users'
                        )
                    )
                )
            ),
            
            'user' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/user[/:action][/type/:type][/wid/:wid]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'type' => '[0-9]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\User',
                        'action' => 'index'
                    )
                )
            )
        )
    ),
    
    'view_manager' => array(
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            'header' => __DIR__ . '/../../ManageClient/view/header.phtml',
            'pagination' => __DIR__ . '/../../ManageClient/view/pagination.phtml',
            'left-menu' => __DIR__ . '/../../ManageClient/view/left-menu.phtml',
            'flash-message' => __DIR__ . '/../../ManageClient/view/flash-message.phtml',
            'help-messages' => __DIR__ . '/../../ManageClient/view/help-messages.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array()
        )
    )
);