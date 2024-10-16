<?php


namespace EnseignantEnseignement\Modele\Entity;

use Psalm\Internal\Type\ParseTree\Value;

class Enseignant{

    /** @var int|null */
    public $id;

    /** @var string|null */
    public $lastname;

    /** @var string|null */
    public $firstname;

    /** @var string|null */
    public $email;

    /** @var string|null */
    public $password;

    /** @var int|null */
    public $UcMax;

    /** @var int|null */
    public $idStatut;

    /** @var int|null */
    public $idRole;

    /** @var int|null */
    public $GCM;

    /** @var int|null */
    public $GTD;

    /** @var int|null */
    public $GTP;

    /** @var string|null */
    public $_statut;

    /** @var string|null */
    public $_role;


    /** @var InputFilter */
    private $inputFilter;


    /**
     * setData
     * 
     * Permet de set la data 
     * Warning: exchangeArray doit etre dans la class pour que laminas arrivent a renvoyer les données dans le resulset des tables
     * @param array
     * Le tableaux doit etre associatif et contenir toute les clé 
     */
    public function exchangeArray(array $data){

        !empty($data["id"])?$this->id = $data["id"] : $this->id = null;

        !empty($data["lastname"])?$this->lastname = $data["lastname"] : $this->lastname = null;

        !empty($data["firstname"])?$this->firstname = $data["firstname"] : $this->firstname = null;

        !empty($data["email"])?$this->email = $data["email"] : $this->email  = null;

        !empty($data["password"])?$this->password = $data["password"] : $this->password =  null;

        !empty($data["UcMax"])?$this->UcMax = $data["UcMax"] : $this->UcMax  = null;

        !empty($data["idStatut"])?$this->idStatut = $data["idStatut"] : $this->idStatut = null;

        !empty($data["idRole"])?$this->idRole = $data["idRole"] : $this->idRole =  null;

        !empty($data["GCM"])?$this->GCM = $data["GCM"] : $this->GCM =  null;

        !empty($data["GTD"])?$this->GTD = $data["GTD"] : $this->GTD = null;

        !empty($data["GTP"])?$this->GTP = $data["GTP"] : $this->GTP = null;

        !empty($data["_statut"])?$this->_statut = $data["_statut"] : $this->_statut = null;

        !empty($data["_role"])?$this->_role = $data["_role"] : $this->_role = null;
    }


    /**
     * getInArray
     * 
     * permet de récupéré les valeur dans un tableau 
     * 
     * @return array
     */
    public function getInArray(){

        return [

            "id"=> $this->id,

            "lastname"=> $this->lastname,

            "firstname"=> $this->firstname,

            "email"=> $this->email,

            "password"=> $this->password,

            "UcMax"=> $this->UcMax,

            "idStatut"=> $this->idStatut,

            "idRole"=> $this->idRole,

            "GCM"=> $this->GCM,

            "GTD"=> $this->GTD,

            "GTP"=> $this->GTP,

            "_statut"=> $this->_statut,

            "_role"=> $this->_role,
        ];

    }

    /**
     * getValidValue
     * 
     * retourne un tableau des donnée que sont définie
     * 
     * @return array|bool
     */
    public function getValidValue(){

        $array = $this->getInArray();

        if($array){

            foreach($array as $k => $value){

                if(is_null($value)){
                     unset($array[$k]);
                }
            }
    
            return $array;

        }

        return false;

        

    }



  
}