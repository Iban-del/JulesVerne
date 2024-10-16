<?php

declare(strict_types=1);


namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
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
use Laminas\Form\Annotation\Exclude;
use Laminas\Session\Container;
use Session\Model\Session;
use Laminas\Mvc\MvcEvent;
use Authentication\Model\Adapter\AdapterAuthentication;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Validator\Authentication;

class IndexController extends AbstractActionController
{
    /** @var Session  */
    private $session;

    /** @var EnseignantTable */
    private $enseignantTable;

    /** @var EnseignementTable */
    private $enseignementTable;

    /** @var RoleTable */
    private $roleTable;

    /** @var StatutTable */
    private $statutTable;



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
    }



    /**
     * retourne une instance de Session
     * 
     * @return Session
     */
    protected function getSession(){

        return $this->session = new Session("User",$this->enseignantTable,$this->getEvent());

    }


    /**
     * getUserId
     * 
     * permet de récupéré l'id de l'utilisateur
     * 
     * @return int
     */
    protected function getUserId(){

        try{

            /** @var Session */
            $session = $this->getSession() ? $this->getSession() : throw new Exception();

            $value = $session->getValue();

            $value ? true : throw new Exception();

            is_int($value) ? true :  throw new Exception();

            return $value;


        }catch(Exception){

            return "";

        }

    }


    


    /**
     * getUserData
     * 
     * permet de récupéré les données de l'utilisateur actif
     * 
     * @return Enseignant|bool
     */
    private function getUserData(){

       
        
        try{

            //vérification que la valeur se session existe et soit valide puis récupération des données
            //sur l'utilisateur actif
            $id = $this->getUserId();

            is_int($id) ? true : throw new Exception();

            $userData = $this->enseignantTable->get($id);

            $userData ? true : throw new Exception();

            return $userData;
            
        }catch(Exception){
            
            return false;

        }

    }

    /**
     * indexAction
     * 
     * renvoie la vue index
     * 
     * @return ViewModel
     */
    public function indexAction()
    {


        return new ViewModel();
    }


    public function testAction()
    {

        phpinfo();

        return new ViewModel();
    }

   


    /**
     * getUserDataAction
     * 
     * permet de récupéré les donnée de l'utilisateur
     */
    public function getUserDataAction(){

        /** @var Request */
        $request = $this->getRequest();

        if($request->isPost()){

            try{

                /** @var int */
                $id = $this->getUserId();

                is_int($id) ? true : throw new Exception();

                /** @var array */
                $value = $this->enseignantTable->getLabel($id)->getInArray();


                //suppréssion des index inutile
                isset($value["id"]) ? true: throw new Exception();

                unset($value["id"]);

                isset($value["password"]) ? true: throw new Exception();
                
                unset($value["password"]);



                return new JsonModel(["valid"=>true,"value"=>$value]);

            }catch(Exception){

                return new JsonModel(["valid"=>false]);

            }

        }

        return new JsonModel(["valid"=>false]);

        

    }

    /**
     * EnseignementAction
     * 
     * 
     * renvoie la vue des enseignement
     * 
     */
    public function EnseignementAction(){

      

        return [];


    }

    /**
     * getEnseignementAction
     * 
     * renvoie les enseignement sans l'id
     */
    public function getEnseignementAction(){

       

        /** @var Request */
        $request = $this->getRequest();

     

            try{


                $enseignementData = $this->enseignementTable->fetchAll();

                foreach($enseignementData as $enseignement){

                    isset($enseignement->id) ? true : throw new Exception();

                    $enseignement->id = null;
                }

                return new JsonModel(["data"=>$enseignementData]);


            }catch(Exception $e){

                return new JsonModel(["data"=>$e->getMessage()]);

            }
    }

    /**
     * UserAction
     * 
     * renvoie la vue de la page User
     * 
     */
    public function UserAction(){

       

        return [];


    }


    /**
     * getStatutAction
     * 
     * permet de récupéré les statut
     * 
     */
    public function getStatutAction(){

      
        try{

            

            /** @var array */
            $request = $this->statutTable->fetchAll();

            foreach($request as $statut){

                isset($statut->id) ? true : throw new Exception();

                $statut->id = null;
                
            }

            return new JsonModel(["data"=>$request]);

        }catch(Exception $e){

            return new JsonModel(["data"=>$e->getMessage()]);

        }

    }

    /**
     * editValueAction
     * 
     * permet de changement d'une valeur de enseignant
     * 
     */
    public function editValueAction(){

    

        /** @var Request */
        $request =  $this->getRequest();


        if($request->isPost()){

            /** @var array */
            $values = json_decode($request->getContent(),true);

            //récupération de la clé
            $key = ucfirst(htmlentities(trim(array_keys($values)[0])));

            /** @var EnseignantFilter */
            $filter = new EnseignantFilter();

            try{
                //création du nom de la method
                $method = "filter".$key;

                //set les donnée pour le filter de mail
                $filter->$method()->setData($values);

                //vérification de la validité des filters
                if($filter->isValid()){

                    $value = $filter->getValues();

                    //vérification que la mot de passe et la confirmation soit identique
                    //et on hache la mot de passe
                    if(isset($values["confirmation"]) && $key === "Password"){

                        $values["confirmation"] === $value["password"] ? true : throw new Exception("Les deux mot de passe doivent être identique");

                        $value["password"] = password_hash($value["password"],PASSWORD_DEFAULT);

                    }

                    //récupération de l'id
                    $id = $this->getUserId();

                    is_int($id) ? true : throw new Exception();

                    $value["id"] = $id;

                    /** @var Enseignant  */
                    $enseignant = new Enseignant();

                    $enseignant->exchangeArray($value);

                    if($key === "Email"){


                        $userData = $this->enseignantTable->get($id);

                        //si le mail est différent que l'ancien on regarde si existe
                        if($userData->email !== $values["email"] && $this->enseignantTable->getElement(["email"=>$values["email"]]) !== false){

                            return new JsonModel(['success' => false,"message"=>"Le mail existe déja"]);

                        }
                    }

                    $this->enseignantTable->save($enseignant);

                    return new JsonModel(["valid"=>true,"error"=>$this->enseignantTable->getElement(["email"=>$values["email"]])]);
                    
                }

            }catch(Exception $e){

                return new JsonModel(["valid"=>false,"message"=>$e->getMessage()]);

            }

            $message = current($filter->getMessages());

            return new JsonModel(["valid"=>false,"message"=>current($message)]);


        }

        return new JsonModel(["valid"=>false]);


    }


    /**
     * editUcAction
     * 
     * permet de changés l'uc de l'utilisateur actif si se n'est pas un vacataire
     */
    public function editUcAction(){

       

        try{

            //vérification que le Statut de l'utilisateur n'est pas vacataire
            $this->getUserData() ?  $userData = $this->getUserData() : throw new Exception();

            $userData->idStatut !== 32 ? true : throw new Exception();

            /** @var Request */
            $request = $this->getRequest();

            if($request->isPost()){

                $data = json_decode($request->getContent(),true);

                $data ? true : throw new Exception();

                //vérification que la clée existe
                array_key_exists("UcMax",$data) ? true : throw new Exception();

                /** @var EnseignantFilter */
                $filter = new EnseignantFilter();

                $filter->filterUc()->setData($data);

                if($filter->isValid()){

                    /** @var array */
                    $uc = $filter->getValues();

                    $userid = $userData->id;

                    is_int($userid) ? true :  throw new Exception();

                    $enseignant = new Enseignant();

                    $enseignant->exchangeArray($uc);

                    $enseignant->id = $userid;

                    $this->enseignantTable->save($enseignant);

                    return new JsonModel(["valid"=>true]);

                }

                $message = current($filter->getMessages());

                return new JsonModel(["valid"=>false,"message"=>current($message)]);


            }
    


        }catch(Exception ){

            return new JsonModel(["valid"=>false]);
        }

       

    }



}
