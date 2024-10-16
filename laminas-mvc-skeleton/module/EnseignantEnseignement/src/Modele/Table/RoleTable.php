<?php
namespace EnseignantEnseignement\Modele\Table;

use Laminas\Db\TableGateway\TableGatewayInterface;
use EnseignantEnseignement\Modele\Table\TableInterface;
use Exception;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\I18n\Validator\IsInt;
use EnseignantEnseignement\Modele\Entity\Role;
/**
 * Cette class permet d'éffectué des requete sur la table Enseignant
 * 
 * 
 */
class RoleTable implements TableInterface{

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
     * permet de récupéré tout les Enseignement
     * 
     * @return Role
     */
    public function fetchAll()
    {

         // ne pas oublié pour récupéré les donnée il faut packourir le tableau
         $data =  $this->table->select();

         $role = [];
 
         foreach($data as $value){
 
             array_push($role,$value);
         }
 
         return $role;

    }

    /**
     * get
     * permet de récupéré un Role
     * @param int $id
     * @return Role 
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

                throw new Exception("Role: impossible de trouvé l'élément");

             }

             return $row;
        }

        throw new Exception("Role: l'id est invalide");

    }

    /**
     * save
     * permet de sauvgardé un les Role
     * @param $data
     */
    public function save($Role)
    {

        //récupération de l'id
        $id = $Role->id;

        //ont set les données dans un tableaux pour les enregistré en base de données
        //
        $data = [

            "label" => $Role->label,

        ];

        //vérification que l'id ne soit pas égale a 0 ou a null
        if($id === 0 || $id === null)
        {
            $this->table->insert($data);
            return true;
        }


        // on vérifie que l'id existe
        try{

            $this->get($id);

        }catch(Exception $e){

            throw new Exception("Role:l'id n'éxiste pas");
        }
        

        $this->table->update($data,["id"=>$id]);
        return true;
        
    }

    /**
     * delete
     * permet de supprimer un les Role
     * @param int  $id
     */
    public function delete(int $id)
    {

        try{

            $this->get($id);

        }catch(Exception $e){

            throw new Exception("Role:l'id n'éxiste pas");

        }

        $this->table->delete(["id"=>$id]);
        return false;
        
    }

        /**
     * getElement
     * 
     * permet de récupéré un role selon un élément
     * 
     * @param array $element -> ["id"=>6]
     * @return Role|false 
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