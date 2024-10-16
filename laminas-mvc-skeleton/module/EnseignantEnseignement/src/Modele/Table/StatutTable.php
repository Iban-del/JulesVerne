<?php

namespace EnseignantEnseignement\Modele\Table;

use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\TableGateway\TableGateway;
use EnseignantEnseignement\Modele\Table\TableInterface;
use Exception;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Form\Annotation\Exclude;
use EnseignantEnseignement\Modele\Entity\Statut;
class StatutTable implements TableInterface{

    /** @var TableGateway */
    public $table;

    /**
     * __construct
     * initialisation de TableGateway
     * 
     * @param TableGatewayInterface
     */
    public function __construct(TableGatewayInterface $table)
    {
        
        $this->table = $table;

    }

    /**
     * fetchAll
     * permet de récupéré tout les Statut
     * 
     * @return Statut
     */
    public function fetchAll()
    {

         // ne pas oublié pour récupéré les donnée il faut packourir le tableau
         $data =  $this->table->select();

         $statut = [];
 
         foreach($data as $value){
 
             array_push($statut,$value);
         }
 
         return $statut;
        
    }

    /**
     * get
     * permet de récupéré un statut
     * @param int $id
     * @return Statut 
     * 
     */
    public function get(int $id)
    {
        //vérifie que l'id soit un entier et supérieur a 0
        if(is_int($id) && $id > 0)
        {
            /** @var ResultSet */
            $select = $this->table->select(["id"=>$id]);

            $row = $select->current();

            //verifie si row est valide
            if(!$row){
                throw new Exception("Statut: impossible de trouvé l'élément");
            }

            return $row;
        }
        
        throw new Exception("Statut: l'id est invalide");
    }

    /**
     * save
     * permet de sauvgardé un les statut
     * @param $data
     */
    public function save($Statut)
    {
        //récupération de l'id
        /** @var int|null */
        $id = $Statut->id;

        //récupération des données
        $data = [

            "label"=>$Statut->label,
            "coutCm"=>$Statut->coutCm,
            "coutTd"=>$Statut->coutTd,
            "coutTp"=>$Statut->coutTp

        ];

        if($id === 0 || $id === null){

            $this->table->insert($data);
            return true;

        }

        //vérification que l'id existe
        try{

            $this->get($id);

        }catch(Exception $e){

            throw new Exception("Statut:l'id n'éxiste pas");

        }

        $this->table->update($data,["id"=>$id]);
        return true;

    }

    /**
     * delete
     * permet de supprimer un les statut
     * @param int  $id
     */
    public function delete(int $id)
    {

        //vérification que l'id existe
        try{

            $this->get($id);

        }catch(Exception $e){

            throw new Exception("Statut:l'id n'éxiste pas");

        }

        $this->table->delete(["id"=>$id]);
        return true;
        
    }

    /**
     * getElement
     * 
     * permet de récupéré un statut selon un élément
     * 
     * @param array $element -> ["id"=>6]
     * @return Statut|false 
     */
    public function getElement(array $element){


        try{

            /** @var ResultSet */
            $select = $this->table->select($element);

            $row = $select->current();

            if(!$row){

                return false;
            }

            return $row;


        }catch(Exception){

            return false;

        }
        

    }

}