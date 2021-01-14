<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;


class AppController extends Controller
{

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        //AUTHENTIFICATION
        $this->loadComponent('Authentication.Authentication');
    }
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        //on n'autorise pas la vue des messages si pas connecté
        //$this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }
}
