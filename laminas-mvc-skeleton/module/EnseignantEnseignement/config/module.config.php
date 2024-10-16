<?php
/**
 * 
 * fichié de configuration du module
 * 
 * controllers => permet d'instencié les controller automatiquement
 * router => definir le router
 */

use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use EnseignantEnseignement\Controller\EnseignantController;
use EnseignantEnseignement\Controller\EnseignantEnseignementController;
use EnseignantEnseignement\Controller\EnseignementController;
use EnseignantEnseignement\Modele\factory\EnseignantFactory;
use EnseignantEnseignement\Modele\factory\EnseignementFactory;
use EnseignantEnseignement\Modele\factory\RoleFactory;
use EnseignantEnseignement\Modele\factory\StatutFactory;
use EnseignantEnseignement\Modele\Table\EnseignantTable;
use EnseignantEnseignement\Modele\Table\EnseignementTable;
use EnseignantEnseignement\Modele\Table\RoleTable;
use EnseignantEnseignement\Modele\Table\StatutTable;

return [



];