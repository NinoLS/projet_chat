<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Session;

class MessagesController extends AppController
{
    public function index()
    {
        $this->paginate = [
            'limit' => 10,
        ];
        $user = $this->request->getSession()->read('Auth')->username;
        $messages = $this->paginate(
            $this->Messages->find()
                ->where(
                    [
                        'OR' =>
                        [
                            [
                                'user_to' => "$user"
                            ],
                            [
                                'user_from' => "$user"
                            ]
                        ]
                    ]
                )
                ->order(['created' => 'DESC'])
        );

        $this->set(compact('messages'));
    }

    public function view($id = null)
    {
        $message = $this->Messages->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('message'));
    }

    public function add($friend_with)
    {
        $this->paginate = [
            'limit' => 10,
        ];
        $user = $this->request->getSession()->read('Auth')->username;

        //users who added me
        $users_added_me = $this->paginate($this->Messages->Friends
            ->find()
            ->where(['friend_with' => "$user"]));
        $users_added_me = compact('users_added_me');

        //users who i added
        $users_i_added = $this->paginate($this->Messages->Friends
            ->find()
            ->where(['username' => "$user"]));
        $users_i_added = compact('users_i_added');

        //get their names
        $names_added_me = array();
        $names_I_added = array();
        foreach ($users_added_me as $users_tab) {
            foreach ($users_tab as $user_tab) {
                if (!empty($user_tab->username))
                    array_push($names_added_me, $user_tab->username);
            }
        }
        foreach ($users_i_added as $users_tab) {
            foreach ($users_tab as $user_tab) {
                if (!empty($user_tab->friend_with))
                    array_push($names_I_added, $user_tab->friend_with);
            }
        }

        //MY FRIENDS CONVERSATIONS
        $names_friends = array_intersect($names_I_added, $names_added_me);


        if (in_array($friend_with, $names_friends)) {
            $message = $this->Messages->newEmptyEntity();
            if ($this->request->is('post')) {
                $message = $this->Messages->patchEntity($message, $this->request->getData());
                $message['user_from'] = $user;
                $message['user_to']   = $friend_with;
                if ($this->Messages->save($message)) {
                    $this->Flash->success(__('Message envoyé à {0}.', ucfirst($message['user_to'])));

                    return $this->redirect(['action' => "add/$message->user_to"]);
                }
                $this->Flash->error(__("Message non envoyé: rééssayez ou contactez l'administrateur."));
            }

            $all_messages = $this->Messages->find()
                ->where(
                    [
                        'OR' =>
                        [
                            [
                                'user_from' => "$user",
                                'user_to'   => "$friend_with"
                            ],
                            [
                                'user_from' => "$friend_with",
                                'user_to'   => "$user"
                            ]

                        ]
                    ]
                );
            $nb_messages = $all_messages->count();
            $all_messages = $all_messages
                ->order(['created' => 'ASC'])
                ->limit(5)
                ->page($nb_messages % 5);

            //->limit(5);
            //$all_messages = $this->paginate($all_messages);

            $this->set(compact('all_messages', 'friend_with', 'message'));
        } else {
            $this->Flash->error(__('{0} ne fait pas partie des amis.', ucfirst($friend_with)));
            $this->redirect('/chat');
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $message = $this->Messages->get($id);
        if ($this->Messages->delete($message)) {
            $this->Flash->success(__('Message de {0} supprimé.', ucfirst($message->user_from)));
        } else {
            $this->Flash->error(__("Message non supprimé: rééssayez ou contactez l'administrateur."));
        }

        return $this->redirect(['action' => 'index']);
    }
}
