<?php

namespace EnseignantEnseignement\Modele\Table;

use EnseignantEnseignement\Modele\Table\TableInterface;
use Exception;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Form\Annotation\Exclude;
use EnseignantEnseignement\Modele\Entity\EnseignantEnseignement;

class EnseignantEnseignamentTable implements TableInterface{

    /** @var TableGateway */
    private $table;

    public function __construct(TableGatewayInterface $table)
    {

        $this->table = $table;
        
    }


    /**
     * fetchAll
     * 
     * permet la récupération de tous les enseignants enseignements
     * 
     * 
     */
    public function fetchAll()
    {
        /** @var ResultSet */
        $select = $this->table->select();

        $values = [];

        foreach($select as $value){

            array_push($values,$value);

        }

        return $values;
        
    }


    /**
     * get
     * 
     * permet de récupéré un enseignants enseignements
     */
    public function get(int $id){

        try{

            is_int($id) && $id > 0 ? true : throw new Exception();

            /** @var ResultSet */
            $select = $this->table->select(["id"=>$id]);

            $row = $select->current();

            $row ? true : throw new Exception();

            return $row;

        }catch(Exception){

            return false;

        }
        

    }

    /**
     * save
     * 
     * permet l'enregistrement ou la mise a jour du enseignants enseignements
     */
    public function save($data){

        /** @var EnseignantEnseignement*/
        $data;

        $id = $data->id;

        $data = $data->getValidValue();

        if(!$id){

            $this->table->insert($data);
            return;

        }

        try{

            is_int($id) ? true : throw new Exception();

            unset($data["id"]);

            $this->table->update($data,["id"=>$id]);

        }catch(Exception){

            return false;

        }



        
    }


    /**
     * delete
     * 
     * permet de supprimer un enseignants enseignements
     */
    public function delete(int $id){

        try{

            is_int($id) ? true : throw new Exception();

            $this->delete($id);

            return;

        }catch(Exception){

            return false;

        }
        
    }

}