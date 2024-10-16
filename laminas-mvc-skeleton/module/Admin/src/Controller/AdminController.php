<?php

namespace Admin\Controller;

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
use Laminas\Config\Reader\Json;
use Laminas\Form\Annotation\Exclude;
use Laminas\I18n\Validator\IsInt;
use Laminas\Session\Container;
use Session\Model\Session;
use Laminas\Mvc\MvcEvent;


use function PHPSTORM_META\type;

class AdminController extends AbstractActionController{

    public $test = "null";
    /** @var EnseignantTable */
    protected $enseignantTable;

    /** @var EnseignementTable */
    protected $enseignementTable;

    /** @var RoleTable */
    protected $roleTable;

    /** @var StatutTable */
    protected $statutTable;

    /** @var Session */
    protected $session;


    /**
     * __construct
     * permet d'instancié les dependence et les variable de class
     * 
     * @return void
     */
    public function __construct(EnseignantTable $enseignantTable,EnseignementTable $enseignementTable,RoleTable $roleTable,StatutTable $statutTable)
    {


        $this->enseignantTable = $enseignantTable;

        $this->enseignementTable = $enseignementTable;

        $this->roleTable = $roleTable;

        $this->statutTable = $statutTable;

      
        
        
    }
   
    /**
     * indexAction
     * 
     * action a l'index
     */
    public function indexAction()
    {

        

        return new ViewModel();
        
    }


    /**
     * enseignantAction
     * 
     * gère la partit enseignant de l'Admin
     * 
     */
    public function enseignantAction(){

        

        return [];
    }

    /**
     * listEnseignantsAction 
     * requête ajax pour la liste des enseignants
     * @return JsonModel
     */
    public function listEnseignantsAction(){

        
       
        $data = $this->enseignantTable->getLabel();

        
        $response = [
            "data" => $data
        ];
        return new JsonModel($response);

    }

    /**
     * listEnseignantsAction 
     * requête ajax pour récupéré un enseignants
     * @return JsonModel
     */
    public function setEnseignantsAction(){

       

        /** @var Request */
        $request = $this->getRequest();

        $error = "";

    if ($request->isPost()) {
        try{

            $data = $request->getContent();  // Récupérer les données JSON
            
            $data = json_decode($data, true); // Convertir en tableau associatif

            $filter = new EnseignantFilter();// on définié les filtre pour les enseignant
    
            $filter->FilterForm()->setData($data);
            
            //validation des données pour effectué les différente requete et cryptage
            if($filter->isValid()){

                /** @var array */
                $formData  = $filter->getValues();

                /** @var int|null */
                $id = $formData["id"];
               
                  /** @var Enseignant */
                $enseignant = new Enseignant();

                //vérification de l'id
                if(!isset($id) && empty($id)){

                    /** @var string */
                    $formData["password"] = password_hash($formData["password"],PASSWORD_DEFAULT);

                     //on vérifie que l'email n'éxiste pas
                     /** @var Enseignant */
                     $validMail = $this->enseignantTable->getElement(["email"=>$formData["email"]]);

                     if($validMail !== false){
 
                         return new JsonModel(['success' => false,"error"=>$error,"message"=>"Le mail existe déja"]);
 
                     }

                }else{

                    //si il y a un id on verifie que le mot de passe ne soit pas le même pour le crypté
                    /** @var Enseignant */
                    $userData = $this->enseignantTable->get($id);

                    if($userData->password !== $formData["password"]){

                        $formData["password"] = password_hash($formData["password"],PASSWORD_BCRYPT);

                    }


                    //empèchement de changé de statut les andmin
                    if($userData->idStatut === 22){

                        $formData["idStatut"] == 22;

                    }

                    //si le mail est différent que l'ancien on regarde si existe
                    if($userData->email !== $formData["email"] && $this->enseignantTable->getElement(["email"=>$formData["email"]]) !== false){

                        return new JsonModel(['success' => false,"error"=>$error,"message"=>"Le mail existe déja"]);

                    }

                 
                }

                $enseignant->exchangeArray($formData);
                

                //enregitrement en base de donnée
                $this->enseignantTable->save($enseignant);

                //renvoie du json avec success a true
                return new JsonModel(['success' => true,"error"=>$error,"message"=>""]);

                


                

            }else{
                $message = current($filter->getMessages());
                //renvoie du json avec success a false
                return new JsonModel(['success' => false,"error"=>$filter->isValid(),"message"=>current($message)]);

            }
          

           
    
        }catch(Exception $e){

            return new JsonModel(['success' => false,"error"=>$e->getMessage(),"message"=>$e->getFile()]);
        }
        
        
    }
    //renvoie du json avec success a false
    return new JsonModel(['success' => false,"error"=>"letest","message"=>""]);

    }

    public function deleteEnseignantAction(){

       

        /** @var Request */
        $request = $this->getRequest();

        if($request->isPost()){

            try{

                $data = json_decode($request->getContent(),true);


                if(isset($data["id"]) && is_int($data["id"])){

                    $this->enseignantTable->delete($data["id"]);

                    return new JsonModel(["valid"=>true]);

                }

                return new JsonModel(["valid"=>false]);

            }catch(Exception){
                
                return new JsonModel(["valid"=>false]);

            }

        }

        return new JsonModel(["valid"=>false]);


    }

    /**
     * getIdStatut
     * 
     * permet de récupéré le label en fonction de l'id
     * 
     * @return string
     */
    public function getLabelByIdAction(){

       

        /** @var Request */
        $request = $this->getRequest();

        if($request->isPost()){

            try{

                $data = json_decode($request->getContent(),true);

                $table = isset($data["table"]) ? $data["table"] : false ;

                // vérification que table soit statut ou role
                $table === "statut" || $table === "role" ? true : throw new Exception();

                $table = $table."Table";
                
                $id = isset($data["id"]) ? $data["id"] : false;

                //vérification que l'id soit un entier
                is_int($id) ? true : throw new Exception();

                /** @var Statut|Role */
                $select = $this->$table->get($id);

                return new JsonModel(["valid"=>true,"label"=>$select->label]);

            }catch(Exception){

                return new JsonModel(["valid"=>false]);

            }

        }

        return new JsonModel(["valid"=>false]);

    }

    /**
     * enseignantAction
     * 
     * gère la partit enseignant de l'Admin
     * 
     */
    public function enseignementAction(){

       

        return [];
    }

    /**
     * setEnseignementAction
     * 
     * cette methode permet l'enregistrement d'un enseignement et la validité des données
     */
    public function setEnseignementAction(){

        

        /** @var Request */
        $request = $this->getRequest();


        if($request->isPost()){

            $data = $request->getContent();

            $data = json_decode($data,true);

            $filter = new EnseignementFilter();

            $filter->FilterForm()->setData($data);

            if($filter->isValid()){

                try{

                    $enseignement = new Enseignement();

                    $enseignement->exchangeArray($filter->getValues());
    
                    $this->enseignementTable->save($enseignement);

                    return new JsonModel(["success"=>true]);

                }catch( Exception $e){

                    return new JsonModel(["success"=>false]);

                }

            }

            $message = current($filter->getMessages());

            return new JsonModel(["success"=>false,"message"=>current($message)]);
            
            
        }

        return new JsonModel(["success"=>false]);

    }

    /**
     * listEnseignementAction 
     * requête ajax pour la liste des enseignement
     * @return JsonModel
     */
    public function listEnseignementAction(){

       
        $data = $this->enseignementTable->fetchAll();

        $response = [
            "data" => $data
        ];
        return new JsonModel($response);

    }

    /**
     * deleteEnseignementAction
     * 
     * fonction pour delete un enseignement
     * 
     */
    public function deleteEnseignementAction(){

        
        /** @var Request */
        $request = $this->getRequest();

        if($request->isPost()){

            //révipération, validation des données et requete sql pour supprimer l'id
            try{

                $data = json_decode($request->getContent(),true);

                if(isset($data["id"]) && is_int($data["id"])){

                        $id = $data["id"];

                        $this->enseignementTable->delete($id);

                        return new JsonModel(["valid"=>true]);


                }

                return new JsonModel(["valid"=>False]);

            }catch(Exception){

                return new JsonModel(["valid"=>False]);

            }
           
           

        }

        return new JsonModel(["valid"=>False]);

    }


    /**
     * enseignantAction
     * 
     * gère la partit enseignant de l'Admin
     * 
     */
    public function roleAction(){

       
        return [];
    }

    /**
     * listRoleAction
     * 
     * Renvoie un Json avec les role
     * @return JsonModel
     */
    public function listRoleAction(){

        

        $data = $this->roleTable->fetchAll();

        $response = [
            "data"=> $data
        ];

        return new JsonModel($response);

    }

    
    /**
     * setRoleAction
     * 
     * permet l'ajout ou la modification d'un role
     * 
     */
    public function setRoleAction(){

        

        /** @var Request */
        $request = $this->getRequest();

        if($request->isPost()){

            $data = $request->getContent();

            $data = json_decode($data,true);

            $filter = new RoleFilter();

            $filter->FilterForm()->setData($data);

            if($filter->isValid()){

                try{
                    $role = new Role();

                    $formData = $filter->getValues() ;

                    //vérification de l'id
                    if(!isset($formData["id"])){

                        if($this->roleTable->getElement(["label"=>$formData["label"]]) !== false){

                            return new JsonModel(["success"=>false,"message"=>"Le rôle èxiste déja"]);
        
                        }

                    }else{

                        $id = $formData["id"];

                        try{

                            is_int($id) ? true : throw new Exception();

                            $role = $this->roleTable->get($id);

                            $role ? true : throw new Exception();


                            if($role->label !== $formData["label"] && $this->roleTable->getElement(["label"=>$formData["label"]]) !== false){

                                return new JsonModel(["success"=>false,"message"=>"Le rôle èxiste déja"]);
            
                            }


                        }catch(Exception){
                            return new JsonModel(["success"=>false,"message"=>"Erreur de requete"]);
                        }

                    }

                   

                    $role->exchangeArray($filter->getValues($formData));

                    $this->roleTable->save($role);

                    return new JsonModel(["success"=>true]);

                }catch(Exception $e){

                    return new JsonModel(["success"=>false,"message"=>"Erreur de requete"]);
            
                }

            }

            $message = current($filter->getMessages());

            return new JsonModel(["success"=>false,"message"=>current($message)]);
            

        }

        return new JsonModel(["success"=>false]);
    }

    /**
     * 
     * methode permett&nt de supprimer un role
     * 
     * @return JsonModel
     * 
     */
    public function deleteRoleAction(){

        

        /** @var Request */
        $request = $this->getRequest();

        if($request->isPost()){

            try{

                $data = json_decode($request->getContent(),true);

                //verification que l'id existe
                if(isset($data["id"]) && is_int($data["id"])){

                    $id = $data["id"];

                    
                    $this->roleTable->delete($id);

                    return new JsonModel(["valid"=>true]);


                }
                
                return new JsonModel(["valid"=>false]);


            }catch(Exception){

                return new JsonModel(["valid"=>false]);

            }

           
            

        }

        return new JsonModel(["valid"=>false]);

    }


    /**
     * enseignantAction
     * 
     * gère la partit enseignant de l'Admin
     * 
     */
    public function statutAction(){

       

        return [];
    }

    /**
     * listRoleAction
     * 
     * Renvoie un Json avec les statut
     * @return JsonModel
     */
    public function listStatutAction(){

        

        $data = $this->statutTable->fetchAll();

        $response = [
            "data"=> $data
        ];

        return new JsonModel($response);

    }

    /**
     * setStatutAction
     * 
     * permet de modifier et d'ajouter un statut
     */
    public function setStatutAction(){

       

        /** @var Request */
        $request = $this->getRequest();

        if($request->isPost()){

            $data = json_decode($request->getContent(),true);

            $filter = new StatutFilter();

            $filter->FilterForm()->setData($data);

            if($filter->isValid()){

                $statut = new Statut();

                $formData = $filter->getValues();

                //on vérifie que l'id existe 

                if(!isset($formData["id"])){

                    if($this->statutTable->getElement(["label"=>$formData["label"]]) !== false){

                        return new JsonModel(["success"=>false,"message"=>"Le Statut èxiste déja"]);
    
                    }

                }else{

                    /**
                     * vérification que le mail n'existe pas si le mail est différent 
                     */
                    try{

                        $id = $formData["id"];

                        is_int($id) ? true : throw new Exception();

                        $statutData = $this->statutTable->get($id);

                        $statutData ? true : throw new Exception();

                        if($statutData->label !== $formData["label"] && $this->statutTable->getElement(["label"=>$formData["label"]]) !== false){

                            return new JsonModel(["success"=>false,"message"=>"Le Statut èxiste déja"]);
        
                        }

                    }catch(Exception){

                        return new JsonModel(["success"=>false,"message"=>"échec de la requête"]);

                    }
                        
                }

               

                $statut->exchangeArray($formData);

                $this->statutTable->save($statut);

                return new JsonModel(["success"=>true]);

            }

            $message = current($filter->getMessages());

            return new JsonModel(["success"=>false,"message"=>current($message)]);
        }

        return new JsonModel(["success"=>false,"message"=>"échec de la requête"]);

    }


    public function deleteStatutAction(){

       

        /** @var Request */
        $request = $this->getRequest();

        //vérification que la requête en en post
        if($request->isPost()){

            
            try{

                $data =json_decode($request->getContent(),true);

                //vérification que l'id soit un entier
               if(isset($data["id"]) && is_int($data["id"])){

                $this->statutTable->delete($data["id"]);

                return new JsonModel(["valid"=>true]);

               }
                
               return new JsonModel(["valid"=>null]);

            }catch(Exception $e){

                return new JsonModel(["valid"=>null]);
            }
        }

        return new JsonModel(["valid"=>false]);

    }


    public function enseignantEnseignementAction(){

        return [];

    }



    
}