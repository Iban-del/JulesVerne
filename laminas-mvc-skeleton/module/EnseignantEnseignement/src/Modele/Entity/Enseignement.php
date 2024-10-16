<?php

namespace EnseignantEnseignement\Modele\Entity;


class Enseignement{

    /** @var int|null */
    public $id;

    /** @var string|null */
    public $training;

    /** @var int|null */
    public $semester;

    /** @var string|null */
    public $reference;

    /** @var string|null */
    public $title;

    /** @var string|null */
    public $statut;

    /** @var int|null */
    public $hoursCm;

    /** @var int|null */
    public $hoursTd;

    /** @var int|null */
    public $hoursTp;

    /** @var int|null */
    public $workforce;

    /** @var int|null */
    public $grCm;

    /** @var int|null */
    public $grTd;

    /** @var int|null */
    public $grTp;


    /**
     * setData
     * 
     * Permet de set la data 
     * Warning: exchangeArray doit etre dans la class pour que laminas arrivent a renvoyer les données dans le resulset des tables
     * @param array
     * Le tableaux doit etre associatif et contenir toute les clé 
     */
    public function exchangeArray(array $data){

        !empty($data["id"])?$this->id = $data["id"] : $this->id =  null;

        !empty($data["training"])?$this->training = $data["training"] : $this->training  = null;

        !empty($data["semester"])?$this->semester = $data["semester"] : $this->semester = null;

        !empty($data["reference"])?$this->reference = $data["reference"] : $this->reference = null;

        !empty($data["title"])?$this->title = $data["title"] : $this->title =  null;

        !empty($data["statut"])?$this->statut = $data["statut"] : $this->statut = null;

        !empty($data["hoursCm"])?$this->hoursCm = $data["hoursCm"] : $this->hoursCm =  null;

        !empty($data["hoursTd"])?$this->hoursTd = $data["hoursTd"] : $this->hoursTd = null;

        !empty($data["hoursTp"])?$this->hoursTp = $data["hoursTp"] : $this->hoursTp =  null;

        !empty($data["workforce"])?$this->workforce = $data["workforce"] : $this->workforce = null;

        !empty($data["grCm"])?$this->grCm = $data["grCm"] : $this->grCm = null;

        !empty($data["grTd"])?$this->grTd = $data["grTd"] : $this->grTd =  null;

        !empty($data["grTp"])?$this->grTp = $data["grTp"] : $this->grTp =  null;
    }
}