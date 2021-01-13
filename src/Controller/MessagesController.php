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
                ->where(['user_to' => "$user"] /*,'user_from' => "$user_from")*/)
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

    public function add()
    {
        $message = $this->Messages->newEmptyEntity();
        if ($this->request->is('post')) {
            $message = $this->Messages->patchEntity($message, $this->request->getData());
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message could not be saved. Please, try again.'));
        }
        $this->set(compact('message'));
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
            $this->Flash->success(__('The message has been deleted.'));
        } else {
            $this->Flash->error(__('The message could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function conv($friend_with)
    {
        $user = $this->request->getSession()->read('Auth')->username;
        $messages = $this->Messages->find()
            ->where([
                'user_from' => "$user",
                'user_to'   => "$friend_with"
            ]);


        $messages = $this->paginate($messages);
        $this->set(compact('messages', 'friend_with'));
    }
}
