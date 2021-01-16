<?php

declare(strict_types=1);

namespace App\Controller;

class UsersController extends AppController
{
    public function index()
    {
        $user = $this->request->getSession()->read('Auth')->username;
        if ($user == 'admin') {
            $this->paginate = [
                'limit' => 20,
            ];
            $users = $this->paginate($this->Users);

            $this->set(compact('users'));
        } else $this->redirect('/chat');
    }

    public function view($id = null)
    {
        $user = $this->request->getSession()->read('Auth')->username;
        if ($user == 'admin') {
            $user = $this->Users->get($id, [
                'contain' => [],
            ]);

            $this->set(compact('user'));
        } else $this->redirect('/chat');
    }

    public function add()
    {
        $user = $this->request->getSession()->read('Auth')->username;
        if ($user == 'admin') {
            $user = $this->Users->newEmptyEntity();
            if ($this->request->is('post')) {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Utilisateur {0} créé.', ucfirst($user->username)));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('Utilisateur {0} non créé.', ucfirst($user->username)));
            }
            $this->set(compact('user'));
        } else $this->redirect('/chat');
    }

    public function edit($id = null)
    {
        $user = $this->request->getSession()->read('Auth')->username;
        if ($user == 'admin') {
            $user = $this->Users->get($id, [
                'contain' => [],
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Utilisateur {0} édité.', ucfirst($user->username)));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('Utilisateur {0} non édité.', ucfirst($user->username)));
            }
            $this->set(compact('user'));
        } else $this->redirect('/chat');
    }

    public function delete($id = null)
    {
        $user = $this->request->getSession()->read('Auth')->username;
        if ($user == 'admin') {
            $this->request->allowMethod(['post', 'delete']);
            $user = $this->Users->get($id);
            if ($this->Users->delete($user)) {
                $this->Flash->success(__('Utilisateur {0} supprimé.', ucfirst($user->username)));

                /* relative records */
                //in FRIENDS table
                $in_friends = $this->paginate($this->Users->Friends->find()
                    ->where([
                        'OR' =>
                        [
                            [
                                'username' => $user->username,
                            ],
                            [
                                'friend_with' => $user->username,
                            ]
                        ]
                    ]));

                foreach ($in_friends as $record) {
                    $this->Users->Friends->delete($record);
                }

                //in MESSAGES table
                $in_messages = $this->paginate($this->Users->Messages->find()
                    ->where([
                        'OR' =>
                        [
                            [
                                'user_from' => $user->username,
                            ],
                            [
                                'user_to' => $user->username,
                            ]
                        ]
                    ]));

                foreach ($in_messages as $record) {
                    $this->Users->Messages->delete($record);
                }


                //in MESSAGES table
            } else {
                $this->Flash->error(__('Utilisateur {0} non supprimé.', ucfirst($user->username)));
            }

            return $this->redirect(['action' => 'index']);
        } else $this->redirect('/chat');
    }


    /*SYSTEME D'AUTHENTIFICATION*/

    //M - pas besoin de se connecter
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configurez l'action de connexion pour ne pas exiger d'authentification,
        // évitant ainsi le problème de la boucle de redirection infinie
        $this->Authentication->addUnauthenticatedActions(['login']);
        $this->Authentication->addUnauthenticatedActions(['login', 'add']);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // indépendamment de POST ou GET, rediriger si l'utilisateur est connecté
        if ($result->isValid()) {
            // rediriger vers /articles après la connexion réussie
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'friends', //MOI
                'action' => 'conversations',
            ]);

            return $this->redirect($redirect);
        }
        // afficher une erreur si l'utilisateur a soumis le formulaire
        // et que l'authentification a échoué
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Votre identifiant ou votre mot de passe est incorrect.'));
        }
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        // indépendamment de POST ou GET, rediriger si l'utilisateur est connecté
        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }
}
