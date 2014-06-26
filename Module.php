<?php
namespace Users;

use Users\Model\UsersTable;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Users\Service\UserMailServices;
use Users\Service\UserEncryption;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Users\Model\UsersTable' => function ($serviceManager)
                {
                    $dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
                    $table = new UsersTable($dbAdapter);
                    return $table;
                },
                'Users\Model\AuthStorage' => function ($serviceManager)
                {
                    return new \Users\Model\AuthStorage('authStorage');
                },
                'Users\Service\UserMailServices' => function ($serviceManager)
                {
                    return new UserMailServices($serviceManager);
                },
                'Users\Service\UserEncryption' => function ($serviceManager)
                {
                    return new UserEncryption(null, $serviceManager);
                },
                'AuthService' => function ($serviceManager)
                {
                    $dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'users', 'email', 'password');
                    
                    $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
                    $authService->setStorage($serviceManager->get('Users\Model\AuthStorage'));
                    
                    return $authService;
                }
            )
        );
    }

    public function onBootstrap($e)
    {
        $app = $e->getApplication();
        $em = $app->getEventManager();
        $sm = $app->getServiceManager();
        $config = $sm->get('Config');
        
        $list = $config['whitelist'];
        $auth = $sm->get('AuthService');
        
        $em->attach(MvcEvent::EVENT_ROUTE, function ($e) use($list, $auth, $sm)
        {
            $match = $e->getRouteMatch();
            
            // No route match, this is a 404
            if (! $match instanceof RouteMatch) {
                return;
            }
            
            // Route is whitelisted
            $name = $sm->get('request')
                ->getUri()
                ->getPath();
            
            if (strpos($name, 'reset-password') || in_array($name, $list)) {
                return;
            }
            
            // User is authenticated
            if ($auth->hasIdentity()) {
                return;
            }
            
            // Redirect to the user login page, as an example
            $router = $e->getRouter();
            $url = $router->assemble(array(), array(
                'name' => 'users'
            ));
            
            $response = $e->getResponse();
            $response->getHeaders()
                ->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
            
            return $response;
        }, - 100);
    }
}
