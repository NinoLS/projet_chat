<?php

declare(strict_types=1);

namespace App\Controller;


class FriendsController extends AppController
{
    public function index()
    {
        $user = strtolower($this->request->getSession()->read('Auth')->username);

        //users who added me
        $users_added_me = $this->Friends
            ->find()
            ->where(['friend_with' => "$user"]);
        $users_added_me = compact('users_added_me');

        //users who i added
        $users_i_added = $this->Friends
            ->find()
            ->where(['username' => "$user"]);
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

        //MY FRIENDS
        $names_friends = array_intersect($names_I_added, $names_added_me);
        $friends = $this->Friends->find()
            ->where([
                'username' => "$user",
                'friend_with IN' => ($names_friends != array()) ? $names_friends : ['null']
            ]);

        //USERS WHO I ADDED (only)
        $names_tmp = array_diff($names_I_added, $names_friends);
        $users_i_added = $this->Friends->find()
            ->where([
                'username' => "$user",
                'friend_with IN' => ($names_tmp != array()) ? $names_tmp : ['null'],
            ]);

        //USERS WHO ADDED ME (only)
        $names_tmp = array_diff($names_added_me, $names_friends);
        $users_added_me = $this->Friends->find()
            ->where([
                'username IN' => ($names_tmp != array()) ? $names_tmp : ['null'],
                'friend_with' => "$user"
            ]);





        $this->set(compact('friends', 'users_added_me', 'users_i_added'));
    }

    public function add()
    {
        $friend = $this->Friends->newEmptyEntity();
        if ($this->request->is('post')) {
            $friend = $this->Friends->patchEntity($friend, $this->request->getData());
            unset($friend['username']);
            $friend['username'] = $this->request->getSession()->read('Auth')->username;
            $friend['friend_with'] = strtolower($friend['friend_with']);
            if ($this->Friends->save($friend)) {
                $this->Flash->success(__("{0} ajouté.", ucfirst($friend->friend_with)));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("Impossible d'envoyé la demande d'ami à `{0}`.", ucfirst($friend->friend_with)));
        }
        $this->set(compact('friend'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $friend = $this->Friends->get($id);
        if ($this->Friends->delete($friend)) {
            $this->Flash->success(__('{0} supprimé.', ucfirst($friend->friend_with)));
        } else {
            $this->Flash->error(__("{0} n'a pu être supprimé: réessayez ou contactez l'administrateur.", ucfirst($friend->friend_with)));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function conversations()
    {
        $user = strtolower($this->request->getSession()->read('Auth')->username);

        //users who added me
        $users_added_me = $this->Friends
            ->find()
            ->where(['friend_with' => "$user"]);
        $users_added_me = compact('users_added_me');

        //users who i added
        $users_i_added = $this->Friends
            ->find()
            ->where(['username' => "$user"]);
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
        $conversations = $this->Friends->find()
            ->where([
                'username' => "$user",
                'friend_with IN' => ($names_friends != array()) ? $names_friends : ['null']
            ]);

        $this->set(compact('conversations','user'));
    }
}
