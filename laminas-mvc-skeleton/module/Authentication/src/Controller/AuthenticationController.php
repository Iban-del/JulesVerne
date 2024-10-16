<?php

namespace Authentication\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use EnseignantEnseignement\Modele\Table\EnseignantTable;
use EnseignantEnseignement\Modele\Table\EnseignementTable;
use EnseignantEnseignement\Modele\Table\RoleTable;
use EnseignantEnseignement\Modele\Table\StatutTable;
use EnseignantEnseignement\Modele\Entity\Enseignant;
use EnseignantEnseignement\Modele\Entity\Enseignement;
use EnseignantEnseignement\Modele\Filter\EnseignantFilter;
use EnseignantEnseignement\Modele\Filter\EnseignementFilter;
use EnseignantEnseignement\Modele\Filter\RoleFilter ;
use EnseignantEnseignement\Modele\Filter\StatutFilter;
use EnseignantEnseignement\Modele\Entity\Role;
use EnseignantEnseignement\Modele\Entity\Statut;
use Exception;
use Authentication\Model\Adapter\AdapterAuthentication;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Validator\Authentication;
use Laminas\Session\Container;
use Laminas\Mvc\MvcEvent;
use Laminas\Mvc\ModuleRouteListener;
use Session\Model\Session;
use Laminas\Authentication\Storage\Session as SessionStorage;

class AuthenticationController extends AbstractActionController{


    /** @var EnseignantTable */
    private $enseignantTable;

    /** @var EnseignementTable */
    private $enseignementTable;

    /** @var RoleTable */
    private $roleTable;

    /** @var StatutTable */
    private $statutTable;

    /** @var Session */
    private $session;


    public function __construct(
        EnseignantTable $enseignantTable,
        EnseignementTable $enseignementTable,
        RoleTable $roleTable,
        StatutTable $statutTable,
    
    ){

        //instansiation des dépendence du controller
        $this->enseignantTable = $enseignantTable;
        $this->enseignementTable = $enseignementTable;
        $this->roleTable = $roleTable;
        $this->statutTable = $statutTable;
        $this->event = $this->getEvent();
    }


    /**
     * getSession
     * 
     * permet de récupéré la class session
     * 
     * @return Session
     */
    private function getSession(){

        /** @var MvcEvent */
        return $session = new Session("User",$this->enseignantTable,$this->event);
          
    }



     /**
     * loginAction
     * 
     * renvoie la vue de login
     * 
     * @return ViewModel
     */
    public function loginAction(){



        return [];
        
    }
    

    /**
     * setloginAction
     * 
     * permet de connecter un utilisateur 
     * 
     * @return JsonModel
     */
    public function setloginAction(){

 
    
        /** @var Request */
        $request = $this->getRequest();


        if($request->isPost()){

            try{


                $data = json_decode($request->getContent(),true);

                // récupération des élément
                $email = trim($data["email"]);

                $password =trim($data["password"]);

                $auth = new AuthenticationService();

                //instentiation de l'AdapterAuthentication
                $authAdapter = new AdapterAuthentication();

                $authAdapter->setValue($email,$password,$this->enseignantTable);
        
                // tentative d'autentification
                $result = $auth->authenticate($authAdapter);

                $auth->setAdapter($authAdapter);
        
                if (! $result->isValid()) {
                    //autentification impossible
                    foreach ($result->getMessages() as $message) {
                       throw new Exception($message);
                    }
                } else {

                 

                    return new JsonModel(["valid"=>true,"message"=>$result->getIdentity()]);
                    
                }

            
            }catch(Exception $e){
            
                return new JsonModel(["valid"=>false,"message"=>$e->getMessage()]);

            }


        }

        return new JsonModel(["valid"=>false]);
        

    }



    /** 
     * disconnectAction
     * 
     * permet de déconnecter un utilisateur
     */
    public function disconnectAction(){

        $serviceManager = $this->getEvent()->getApplication()->getServiceManager();

        /**  @var AuthenticationService $authService */
        $authService = $serviceManager->get(AuthenticationService::class);

        $valid = $this->getSession()->deleteSession($authService);

        return new JsonModel(["valid"=>$valid]);

    }
}