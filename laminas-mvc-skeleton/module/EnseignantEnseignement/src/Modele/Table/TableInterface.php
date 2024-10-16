<?php

namespace EnseignantEnseignement\Modele\Table;
use Laminas\Db\ResultSet\ResultSetInterface;
/**
 * TableInterface
 * 
 * interface pour les Table
 * 
 * @method fetchAll
 * @method get
 * @method save
 * @method delete
 */
interface TableInterface{

    /**
     * fetchAll
     * 
     * permet de récupéré tous les éléments de la Table
     * 
     * 
     */
    public function fetchAll();

    /**
     * get
     * 
     * permet de récupéré un élément de la Table
     * 
     * 
     */
    public function get(int $id);

    /**
     * save
     * 
     * permet de sauvgardé un élément dans la Table
     * 
     */
    public function save($data);

    /**
     * fetchAll
     * 
     * permet de supprimer un élément dans la Table
     * 
     * @return bool
     */
    public function delete(int $id);

}