<?php

declare(strict_types=1);

namespace App\Controller;


class FriendsController extends AppController
{
    public function index()
    {
        $user = $this->request->getSession()->read('Auth')->username;

        //my friends + my requests
        $friends = $this->paginate($this->Friends
            ->find()
            ->where(['username' => "$user"]));


        //users who added me
        $friends_tmp = $this->paginate($this->Friends
            ->find()
            ->where(['friend_with' => "$user"]));
        $friends_tmp = compact('friends_tmp');

        //get their username
        $friends_with_me = array();
        foreach ($friends_tmp as $friend) {
            if (!empty($friend->first()->username))
                array_push($friends_with_me, $friend->first()->username);
        }

        //my friends only
        $friends = $this->paginate($this->Friends->find()
            ->where([
                'username' => "$user",
                'friend_with IN' => $friends_with_me
            ]));

        //users who added me only
        $i_added_them = $this->paginate($this->Friends->find()
            ->where([
                'username' => "$user",
                'friend_with NOT IN' => $friends_with_me
            ]));

        //my request
        $they_added_me = $this->paginate($this->Friends->find()
            ->where([
                'username NOT IN' => $friends_with_me,
                'friend_with' => "$user"
            ]));


        $this->set(compact('friends', 'i_added_them', 'they_added_me'));
    }

    public function add()
    {
        $friend = $this->Friends->newEmptyEntity();
        if ($this->request->is('post')) {
            $friend = $this->Friends->patchEntity($friend, $this->request->getData());
            unset($friend['username']);
            $friend['username'] = $this->request->getSession()->read('Auth')->username;
            if ($this->Friends->save($friend)) {
                $this->Flash->success(__('The friend has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The friend could not be saved. Please, try again.'));
        }
        $this->set(compact('friend'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $friend = $this->Friends->get($id);
        if ($this->Friends->delete($friend)) {
            $this->Flash->success(__('The friend has been deleted.'));
        } else {
            $this->Flash->error(__('The friend could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function conversations()
    {
        $user = $this->request->getSession()->read('Auth')->username;

        $conversations = $this->Friends->find()
            ->where(['username' => "$user"]);

        $$conversations = $this->paginate($conversations);
        $this->set(compact('conversations'));
    }
}
