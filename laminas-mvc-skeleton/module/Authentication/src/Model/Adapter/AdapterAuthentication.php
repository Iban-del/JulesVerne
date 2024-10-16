<?php

namespace Authentication\Model\Adapter;

use Exception;
use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Authentication\Adapter\ValidatableAdapterInterface;
use Laminas\Authentication\Result;
use EnseignantEnseignement\Modele\Table\EnseignantTable;
use EnseignantEnseignement\Modele\Entity\Enseignant;

class AdapterAuthentication implements AdapterInterface{

    /** @var string */
    private $password;

    /** @var string */
    private $email;

    /** @var EnseignantTable */
    private $table;

    /** @var mixed */
    private $identity = null;

    /** @var mixed */
    private $credential = null;

    /** @var bool */
    public $valid;

    public function setValue($email,$password,EnseignantTable $table)
    {

        $this->email = $email ? $email : null;

        $this->password = $password ? $password : null;

        $this->table = $table ? $table : null;
        
    }


    /**
     * authenticate
     * 
     * effectue une tentative d'identification
     * 
     * @return Result
     */
    public function authenticate(){

        try{

            $this->table ? true : throw new Exception();

            $this->password ? true : throw new Exception();

            $this->email ? true : throw new Exception();

            /** @var Enseignant */
            $dataUser = $this->table->getElement(["email"=>$this->email]);

            if($dataUser){

                //vérification que le mot de passe est valide
                if(password_verify($this->password,$dataUser->password)){

                    $this->valid = true;

                    $this->identity = $dataUser->id;

                    return new Result(Result::SUCCESS,$dataUser->id,["Success"]);

                }

                throw new Exception();
            }

            throw new Exception();

        }catch(Exception){

            $this->valid = false;

            return new Result(Result::FAILURE,$this->email,["Connexion impossible"]);

        }

    }

    
}