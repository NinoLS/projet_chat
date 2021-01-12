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
        // pour tous les contrôleurs de notre application, rendre les actions
        // index et view publiques, en ignorant la vérification d'authentification
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }
}
