<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Session;

class MessagesController extends AppController
{
    public function index()
    {
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
            )
            ->order(['created' => 'ASC']);
        $all_messages = $this->paginate($all_messages);

        $this->set(compact('all_messages', 'friend_with', 'message'));
    }

    public function edit($id = null)
    {
        $message = $this->Messages->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $message = $this->Messages->patchEntity($message, $this->request->getData());
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message could not be saved. Please, try again.'));
        }
        $this->set(compact('message'));
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
