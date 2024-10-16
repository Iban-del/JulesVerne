<?php

namespace EnseignantEnseignement\Modele\Entity;

class Role{

    /** @var int|null */
    public $id;

    /** @var string|null */
    public $label;

   

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

        !empty($data["label"])?$this->label = $data["label"] : $this->label = null;

    }
}