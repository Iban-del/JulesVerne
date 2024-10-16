<?php

namespace Session\Model;

use EnseignantEnseignement\Modele\Entity\Enseignant;
use Laminas\Session\Container;
use Exception;
use Laminas\Form\Annotation\Exclude;
use EnseignantEnseignement\Modele\Table\EnseignantTable;
use EnseignantEnseignement\Modele\factory\EnseignantFactory;
use Laminas\Session\SessionManager;
use Laminas\Session\Config\StandardConfig;
use Laminas\Session\Config\SessionConfig;
use Laminas\Mvc\MvcEvent;
use Laminas\Mvc\ModuleRouteListener;
use Laminas\Session\Validator;
use Laminas\Authentication\AuthenticationService;

class Session{


    /** @var string */
    private $name;

    /** @var EnseignantTable  */
    private $enseignant;

    /** @var int */
    private $ttl = 20;

    /** @var MvcEvent */
    private $event;




    public function __construct(string $name,EnseignantTable $enseignantTable, MvcEvent $e)
    {

       

            $this->name = $name;

            $this->enseignant = $enseignantTable;
       
        
    }

     /**
     * bootstrapDeleteSession
     * 
     * permet la suppression automatique de la session
     */
    public function deleteSession(){

        try{

             //vérification que le name et container sont valide
            $this->name ? true: throw new Exception("name not found");

            $this->enseignant ? true: throw new Exception("enseignant not found");

            $container = new Container($this->name);

            if (isset($container->init)) {
                
                $container->getManager()->destroy();

                $this->removeFile();

            }

        }catch(Exception){

            return false;

        }
       


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

    /**
     * getStatutSession
     * 
     * permet de récupéré le statut d'une session 
     * 
     * @param callable
     * 
     * @return bool
     */
    public function getStatutSession(callable $function = null){

        try{

            //vérification que le nama et container sont valide
            $this->name ? true: throw new Exception("name not found");

            $this->enseignant ? true: throw new Exception("enseignant not found");

            //Récupération de la session
          

            $container = new Container($this->name);

            if (isset($container->init)) {

                $userData = $container->username;

                //verification que l'utilisateur existe
                $userData ? true : throw new Exception("userData not valid");
    
                !empty($userData) ? true : throw new Exception("userData empty");
    
                !is_null($userData) ? true : throw new Exception("userData is null");
    
                $this->enseignant->get($userData) ? true :new Exception("enseignant user not found") ;
               
                $container->getManager()->rememberMe($this->ttl);
    
                return true;

            }
                 
           throw new Exception();

        }catch(Exception $e){
    
            if(is_callable($function())){

                $function();

            }


            return $e->getMessage();

        }

    }

    /**
     * getValue
     * 
     * permet de récupéré la valeur stocké dans la session
     * 
     * @return mixed|bool
     */
    public function getValue(){

        try{

            //vérification que le name et container sont valide
            $this->name ? true: throw new Exception();

            $this->enseignant ? true: throw new Exception();
 
            $container = new Container($this->name);

            if (isset($container->init)) {

                return $container->username;
            }

            return $container;

        }catch(Exception){

            return false;

        }

    }    

}