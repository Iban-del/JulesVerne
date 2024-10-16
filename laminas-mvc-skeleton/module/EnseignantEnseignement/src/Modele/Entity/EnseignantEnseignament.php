<?php

namespace EnseignantEnseignement\Modele\Entity;

class EnseignantEnseignement{

    /** @var int */
    public $id;

    /** @var float */
    public $nbGrCm;

    /** @var float */
    public $nbGrTd;

    /** @var float */
    public $nbGrTp;

    /** @var bool */
    public $responsable;

    /** @var int */
    public $idEnseignant;

    /** @var int */
    public $idEnseignement;


    /**
     * exchangeArray
     * 
     * permet de set les data
     * 
     */
    public function exchangeArray(array $data){

        if(is_array($data)){

            $this->id =  !empty($data["id"]) ? $data["id"] : null;

            $this->nbGrCm =  !empty($data["nbGrCm"]) ? $data["nbGrCm"] : null;

            $this->nbGrTd =  !empty($data["nbGrTd"]) ? $data["nbGrTd"] : null;

            $this->nbGrTp =  !empty($data["nbGrTp"]) ? $data["nbGrTp"] : null;

            $this->responsable =  !empty($data["responsable"]) ? $data["responsable"] : null;

            $this->idEnseignant =  !empty($data["idEnseignant"]) ? $data["idEnseignant"] : null;

            $this->idEnseignement =  !empty($data["idEnseignement"]) ? $data["idEnseignement"] : null;

        }

        return false;

    }

    
    /**
     * getInArray
     * 
     * permet de récupéré les données dans un tableau asso
     * 
     * @return array
     */
    public function getInArray(){

        return [

            "id" => $this->id,

            "nbGrCm" => $this->nbGrCm,

            "nbGrTd" => $this->nbGrTd,

            "nbGrTp" => $this->nbGrTp,

            "responsable" => $this->responsable,

            "idEnseignant" => $this->idEnseignant,

            "idEnseignement" => $this->idEnseignement,

        ];

    }


    public function getValidValue(){


        $array = $this->getInArray();

        if(is_array($array)){

            foreach($array as $value){

                if(is_null($value)){
    
                    unset($array[$value]);
    
                }
    
            }

            return $array;

        }

        return false;
       


    }
}