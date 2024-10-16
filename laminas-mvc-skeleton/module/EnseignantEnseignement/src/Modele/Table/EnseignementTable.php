<?php
namespace EnseignantEnseignement\Modele\Table;

use Laminas\Db\TableGateway\TableGatewayInterface;
use EnseignantEnseignement\Modele\Table\TableInterface;
use Exception;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\I18n\Validator\IsInt;
use EnseignantEnseignement\Modele\Entity\Enseignement;

/**
 * Cette class permet d'éffectué des requete sur la table Enseignant
 * 
 * 
 */
class EnseignementTable implements TableInterface{

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
     * @return Enseignement
     */
    public function fetchAll()
    {

        // ne pas oublié pour récupéré les donnée il faut packourir le tableau
        $data =  $this->table->select();

        $enseignement = [];

        foreach($data as $value){

            array_push($enseignement,$value);
        }

        return $enseignement;

    }

    /**
     * get
     * permet de récupéré un Enseignement
     * @param int $id
     * @return Enseignement 
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

                throw new Exception("Enseignement: impossible de trouvé l'élément");

             }

             return $row;
        }

        throw new Exception("Enseignement: l'id est invalide");

    }

    /**
     * save
     * permet de sauvgardé un les Enseignement
     * @param $data
     */
    public function save($Enseignement)
    {

        //récupération de l'id
        $id = $Enseignement->id;

        //ont set les données dans un tableaux pour les enregistré en base de données
        //
        $data = [

            "training" => $Enseignement->training,
            "semester" => $Enseignement->semester,
            "reference"=> $Enseignement->reference,
            "title"=>$Enseignement->title,
            "statut"=> $Enseignement->statut,
            "hoursCm"=>$Enseignement->hoursCm,
            "hoursTd"=>$Enseignement->hoursTd,
            "hoursTp"=>$Enseignement->hoursTp,
            "workforce"=>$Enseignement->workforce,
            "grCm"=>$Enseignement->grCm,
            "grTd"=>$Enseignement->grTd,
            "grTp"=>$Enseignement->grTp

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

            throw new Exception("Enseignement: l'id n'éxiste pas");
        }
        

        $this->table->update($data,["id"=>$id]);
        return true;
        
    }

    /**
     * delete
     * permet de supprimer un les Enseignement
     * @param int  $id
     */
    public function delete(int $id)
    {

        try{

            $this->get($id);

        }catch(Exception $e){

            throw new Exception("Enseignement: l'id n'éxiste pas");

        }

        $this->table->delete(["id"=>$id]);
        return false;
        
    }


    /**
     * getElement
     * 
     * permet de récupéré un enseignement selon un élément
     * 
     * @param array $element -> ["id"=>6]
     * @return Enseignement|false 
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