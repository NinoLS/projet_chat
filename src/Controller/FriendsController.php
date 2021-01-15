<?php

declare(strict_types=1);

namespace App\Controller;


class FriendsController extends AppController
{
    public function index()
    {
        $user = $this->request->getSession()->read('Auth')->username;

        $friends = $this->Friends->find()
            ->where(['username' => "$user"]);
        $friends = $this->paginate($friends);




        $friends_with = array();
        $friends_tmp = $this->paginate($this->Friends->find()
            ->where(['friend_with' => "$user"]));
        $friends_tmp = compact('friends_tmp');
        foreach ($friends_tmp as $friend) {
            //print_r($friend->first()->friend_with);
            if (!empty($friend->first()->username))
                array_push($friends_with, $friend->first()->username);
        }


        $friends = $this->Friends->find()
            ->where([
                'username' => "$user",
                'friend_with IN' => $friends_with
            ]);
        $friends = $this->paginate($friends);


        $this->set(compact('friends'));
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

        $conversations = $this->paginate($conversations);
        $this->set(compact('conversations'));
    }
}
