<?php
namespace EnseignantEnseignement\Modele\Table;

use Laminas\Db\TableGateway\TableGatewayInterface;
use EnseignantEnseignement\Modele\Table\TableInterface;
use Exception;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\I18n\Validator\IsInt;
use EnseignantEnseignement\Modele\Entity\Enseignant;
use Laminas\Db\Sql\Select;
use Laminas\Form\Annotation\Exclude;

/**
 * Cette class permet d'éffectué des requete sur la table Enseignant
 * 
 * 
 */
class EnseignantTable implements TableInterface{

    /** @var TableGateway */
    private $table;

    /**
     * __construct
     * 
     * instansiation de la TableGateway
     * 
     * @param TableGatewayInterface
     * 
     */
    public function __construct(TableGatewayInterface $table)
    {
        
        $this->table = $table;

    }


    /**
     * fetchAll
     * permet de récupéré tout les Enseignants
     * 
     * @return Enseignant
     */
    public function fetchAll()
    {
        // ne pas oublié pour récupéré les donnée il faut packourir le tableau
        $data =  $this->table->select();

        $enseignant = [];

        foreach($data as $value){

            array_push($enseignant,$value);
        }

        return $enseignant;

    }

    /**
     * get
     * permet de récupéré un Enseignant
     * @param int $id
     * @return Enseignant 
     * 
     */
    public function get(int $id)
    {

        // vérification de l'id 
        if(is_int($id) && $id > 0){

            /** @var ResultSet */
             $select = $this->table->select(["id"=>$id]);

             $row = $select->current();

            // on vérifie que $row soit valide
             if(!$row){

                throw new Exception("Enseignant: impossible de trouvé l'élément");

             }

             return $row;
        }

        throw new Exception("Enseignant: l'id est invalide");

    }

    /**
     * save
     * permet de sauvgardé un les Enseignant
     * @param $data
     */
    public function save($Enseignant)
    {

        /** @var Enseignant */
        $Enseignant;

        //récupération de l'id
        $id = (int) $Enseignant->id;
       
        //ont set les données dans un tableaux pour les enregistré en base de données
        $data = $Enseignant->getValidValue();
        
        //vérification que l'id ne soit pas égale a 0 ou a null
        if($id === 0 || $id === null)
        {
            
            $this->table->insert($data);
            return;
        }


        // on vérifie que l'id existe
        try{

            $this->get($id);

        }catch(Exception $e){

            throw new Exception("Enseignant:l'id n'éxiste pas");
        }
        

        $this->table->update($data,["id"=>$id]);
        return;
        
    }

    /**
     * delete
     * permet de supprimer un les Enseignant
     * @param int  $id
     */
    public function delete(int $id)
    {

        try{

            $this->get($id);

        }catch(Exception $e){

            throw new Exception("Enseignant:l'id n'éxiste pas");

        }

        $this->table->delete(["id"=>$id]);
        return false;

    }

    /**
     * delete
     * permet de récupéré un élément
     * @param array $element => ["id"=>6]
     */
    public function getElement(array $element){

        try{

            /** @var ResultSet  */
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

    /**
     * 
     * getByLabel
     * 
     * permet de récupéré les enseignant avec leur label de statut et de role
     * 
     * @param int $id = null
     * 
     * @return Enseignant
     */
    public function getLabel(int $id = null){

        try{

            /** @var Select */
            $select = new Select($this->table->getTable());

            $select->join(
                'role',
                'enseignant.idrole = role.id',
                ['_role' => 'label'],
                Select::JOIN_LEFT
            )
            ->join(
                'statut',
                'enseignant.idstatut = statut.id',
                ['_statut' => 'label'],
                Select::JOIN_LEFT
            );

            

            if(is_null($id)){

                /** @var ResultSet */
                $resultSet = $this->table->selectWith($select);

                $rows = [];

                foreach ($resultSet as $row) {

                    array_push($rows,$row);

                }

            }else{

                $select->where->equalTo('enseignant.id',$id);

                /** @var ResultSet */
                $resultSet = $this->table->selectWith($select);

                $rows = $resultSet->current();
            }
            

            return $rows;
            
        }catch(Exception $e){

            return $e->getFile();

        }
        
    }

    

}