<?php

declare (strict_types = 1);

namespace App\Controller;

class MessagesController extends AppController
{
    public function index()
    {
        $user = strtolower($this->request->getSession()->read('Auth')->username);
        $messages = $this->Messages->find()
            ->where(
                [
                    'OR' =>
                    [
                        [
                            'user_to' => "$user",
                        ],
                        [
                            'user_from' => "$user",
                        ],
                    ],
                ]
            )
            ->order(['created' => 'DESC']);

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
        $user = strtolower($this->request->getSession()->read('Auth')->username);
        $friend_with = strtolower($friend_with);

        //users who added me
        $users_added_me = $this->Messages->Friends
            ->find()
            ->where(['friend_with' => "$user"]);
        $users_added_me = compact('users_added_me');

        //users who i added
        $users_i_added = $this->Messages->Friends
            ->find()
            ->where(['username' => "$user"]);
        $users_i_added = compact('users_i_added');

        //get their names
        $names_added_me = array();
        $names_I_added = array();
        foreach ($users_added_me as $users_tab) {
            foreach ($users_tab as $user_tab) {
                if (!empty($user_tab->username)) {
                    array_push($names_added_me, $user_tab->username);
                }

            }
        }
        foreach ($users_i_added as $users_tab) {
            foreach ($users_tab as $user_tab) {
                if (!empty($user_tab->friend_with)) {
                    array_push($names_I_added, $user_tab->friend_with);
                }

            }
        }

        //MY FRIENDS CONVERSATIONS
        $names_friends = array_intersect($names_I_added, $names_added_me);

        //Vérification existence ami (au cas où //scripts injecteurs)
        if (in_array($friend_with, $names_friends)) {
            $message = $this->Messages->newEmptyEntity();
            if ($this->request->is('post')) {
                $message = $this->Messages->patchEntity($message, $this->request->getData());
                $message['user_from'] = $user;
                $message['user_to'] = $friend_with;

                //1ere verification taille (avant modif longs mots)
                if (empty($message->message) || strlen($message->message) >= 254) {
                    $this->Flash->error(__("Message non envoyé : taille inappropriée."));
                    return $this->redirect(['action' => "add/$message->user_to"]);
                }

                //vérification message espace " "
                if ($message->message == " ") {
                    $message->message = "-";
                }

                //vérification long mot
                define('MAX_SIZE_WORD', 12);
                foreach (explode(" ", $message->message) as $word) {
                    if (strlen($word) > MAX_SIZE_WORD) {
                        //on coupe le mot par morceaux de taille MAX_SIZE_WORD
                        $word_to_words = array();
                        for ($i = 0; $i < floor(strlen($word) / MAX_SIZE_WORD) + 1; $i++) {
                            array_push($word_to_words, substr($word, MAX_SIZE_WORD * $i, MAX_SIZE_WORD));
                        }

                        //on remplit le tableau avec ces morceaux
                        $word_new = "";
                        for ($i = 0; $i < floor(strlen($word) / MAX_SIZE_WORD); $i++) {
                            $word_new .= $word_to_words[$i] . "-";
                        }

                        $word_new .= $word_to_words[$i];

                        //si mot initiale multiple de MAX_SIZE_WORD => un "-" en trop
                        if (strlen($word) % MAX_SIZE_WORD == 0) {
                            $word_new[strlen($word_new) - 1] = " ";
                        }

                        //on remplace le mot par le nouveau
                        $message->message = str_replace($word, $word_new, $message->message);
                    }
                }

                //2e verification taille (apres modif longs mots)
                if (strlen($message->message) >= 254) {
                    $this->Flash->error(__("Message non envoyé : taille inappropriée."));
                    return $this->redirect(['action' => "add/$message->user_to"]);
                }

                //cryptage
                $methods = openssl_get_cipher_methods();
                $key = "toutaunefinsauflasaucissequienadeux01012021";
                $message->message = openssl_encrypt($message->message, $methods[64], $key);

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
                                'user_to' => "$friend_with",
                            ],
                            [
                                'user_from' => "$friend_with",
                                'user_to' => "$user",
                            ],

                        ],
                    ]
                )
                ->order(['created' => 'ASC']);

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
            $this->Flash->success(__('Message "{0}.." supprimé.', $message->message));
        } else {
            $this->Flash->error(__("Message non supprimé: rééssayez ou contactez l'administrateur."));
        }

        return $this->redirect(['action' => 'index']);
    }
}
