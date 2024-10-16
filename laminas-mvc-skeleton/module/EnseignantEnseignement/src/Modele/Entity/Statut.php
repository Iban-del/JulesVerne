<?php

namespace EnseignantEnseignement\Modele\Entity;

class Statut{

    /** @var int|null */
    public $id;

    /** @var string|null */
    public $label;

    /** @var string|null */
    public $coutCm;

    /** @var string|null */
    public $coutTd;

    /** @var string|null */
    public $coutTp;

   

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

        !empty($data["coutCm"])?$this->coutCm = $data["coutCm"] : $this->coutCm = null;

        !empty($data["coutTd"])?$this->coutTd = $data["coutTd"] : $this->coutTd = null;

        !empty($data["coutTp"])?$this->coutTp = $data["coutTp"] : $this->coutTp = null;

    }
}