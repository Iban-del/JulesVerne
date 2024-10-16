<?php

declare(strict_types=1);

namespace Session;

use Exception;
use Laminas\Mvc\ModuleRouteListener;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\SessionManager;
use Laminas\Session\Config\SessionConfig;
use Laminas\Session\Container;
use Laminas\Session\Validator;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Validator\Authentication as AuthenticationValidator;
use Authentication\Model\Adapter\AdapterAuthentication;


class Module
{

    public function onBootstrap(MvcEvent $e)
    {

            $serviceManager = $e->getApplication()->getServiceManager();

                /**  @var AuthenticationService $authService */
            $authService = $serviceManager->get(AuthenticationService::class);
        
            $eventManager = $e->getApplication()->getEventManager();

            $moduleRouteListener = new ModuleRouteListener();
    
            $moduleRouteListener->attach($eventManager);
    
            $this->bootstrapSession($e,$authService);
            

    }

    /**
     * removeFile
     * 
     * permet de détruire tous les fichiers de Session
     * 
     */
    public function removeFile(){

        try{
            
            /** @var string */
            $link = "/Users/iban/Documents/ProjetAntoine/ProjetAntoine/laminas-mvc-skeleton/Session";

            /** @var array|bool */
            $files = scandir($link);

            $files ? true : throw new Exception();

            unset($files[0]);
            unset($files[1]);

            //parckour le dossier pour détruire les fichiers
            foreach($files as $file){

              $linkFile = $link."/".$file;

                unlink($linkFile);
   
            }

        }catch(Exception){

            return false;

        }

    }


    public function bootstrapSession(MvcEvent $e,AuthenticationService $authService)
    {
            
        $session = $e->getApplication()
        ->getServiceManager()
        ->get(SessionManager::class);  
        $session->start();

        $container = new Container('User');

        if(!$authService->hasIdentity()){



            return;

        }

        if(isset($container->init)) {

            //$container->getManager()->rememberMe(1200);

            return;

        }

        $serviceManager = $e->getApplication()->getServiceManager();
        $request        = $serviceManager->get('Request');

        $session->regenerateId(true);
        $container->init          = 1;
        $container->remoteAddr    = $request->getServer()->get('REMOTE_ADDR');
        $container->httpUserAgent = $request->getServer()->get('HTTP_USER_AGENT');
        $container->username      = $authService->getIdentity();

        $config = $serviceManager->get('Config');
        if (! isset($config['session'])) {
            return;
        }

        $sessionConfig = $config['session'];

        if (! isset($sessionConfig['validators'])) {
            return;
        }

        $chain   = $session->getValidatorChain();

        foreach ($sessionConfig['validators'] as $validator) {
            switch ($validator) {
                case Validator\HttpUserAgent::class:
                    $validator = new $validator($container->httpUserAgent);
                    break;
                case Validator\RemoteAddr::class:
                    $validator  = new $validator($container->remoteAddr);
                    break;
                default:
                    $validator = new $validator();
                    break;
            }

            $chain->attach('session.validate', array($validator, 'isValid'));
        }
    }


    public function getServiceConfig()
    {
        return [
            'factories' => [
                SessionManager::class => function ($container) {
                    $config = $container->get('config');
                    if (! isset($config['session'])) {
                        $sessionManager = new SessionManager();
                        Container::setDefaultManager($sessionManager);
                        return $sessionManager;
                    }

                    $session = $config['session'];

                    $sessionConfig = null;
                    if (isset($session['config'])) {
                        $class = isset($session['config']['class'])
                            ?  $session['config']['class']
                            : SessionConfig::class;

                        $options = isset($session['config']['options'])
                            ?  $session['config']['options']
                            : [];

                        $sessionConfig = new $class();
                        $sessionConfig->setOptions($options);
                    }

                    $sessionStorage = null;
                    if (isset($session['storage'])) {
                        $class = $session['storage'];
                        $sessionStorage = new $class();
                    }

                    $sessionSaveHandler = null;
                    if (isset($session['save_handler'])) {
                        // class should be fetched from service manager
                        // since it will require constructor arguments
                        $sessionSaveHandler = $container->get($session['save_handler']);
                    }

                    $sessionManager = new SessionManager(
                        $sessionConfig,
                        $sessionStorage,
                        $sessionSaveHandler
                    );

                    Container::setDefaultManager($sessionManager);
                    return $sessionManager;
                },
            ],
        ];
    }
    

}
