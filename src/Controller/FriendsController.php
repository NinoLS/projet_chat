<?php

declare(strict_types=1);

namespace App\Controller;


class FriendsController extends AppController
{
    public function index()
    {
        $friends = $this->paginate($this->Friends);

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
}
