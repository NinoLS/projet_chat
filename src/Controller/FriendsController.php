<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Friends Controller
 *
 * @property \App\Model\Table\FriendsTable $Friends
 * @method \App\Model\Entity\Friend[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FriendsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $friends = $this->paginate($this->Friends);

        $this->set(compact('friends'));
    }

    /**
     * View method
     *
     * @param string|null $id Friend id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $friend = $this->Friends->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('friend'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $friend = $this->Friends->newEmptyEntity();
        if ($this->request->is('post')) {
            $friend = $this->Friends->patchEntity($friend, $this->request->getData());
            if ($this->Friends->save($friend)) {
                $this->Flash->success(__('The friend has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The friend could not be saved. Please, try again.'));
        }
        $this->set(compact('friend'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Friend id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $friend = $this->Friends->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $friend = $this->Friends->patchEntity($friend, $this->request->getData());
            if ($this->Friends->save($friend)) {
                $this->Flash->success(__('The friend has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The friend could not be saved. Please, try again.'));
        }
        $this->set(compact('friend'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Friend id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
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
