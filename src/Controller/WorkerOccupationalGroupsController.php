<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * WorkerOccupationalGroups Controller
 *
 * @property \App\Model\Table\WorkerOccupationalGroupsTable $WorkerOccupationalGroups
 * @method \App\Model\Entity\WorkerOccupationalGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WorkerOccupationalGroupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $workerOccupationalGroups = $this->paginate($this->WorkerOccupationalGroups);

        $this->set(compact('workerOccupationalGroups'));
    }

    /**
     * View method
     *
     * @param string|null $id Worker Occupational Group id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $workerOccupationalGroup = $this->WorkerOccupationalGroups->get($id, [
            'contain' => ['Workers'],
        ]);

        $this->set(compact('workerOccupationalGroup'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $workerOccupationalGroup = $this->WorkerOccupationalGroups->newEmptyEntity();
        if ($this->request->is('post')) {
            $workerOccupationalGroup = $this->WorkerOccupationalGroups->patchEntity($workerOccupationalGroup, $this->request->getData());
            if ($this->WorkerOccupationalGroups->save($workerOccupationalGroup)) {
                $this->Flash->success(__('The worker occupational group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The worker occupational group could not be saved. Please, try again.'));
        }
        $this->set(compact('workerOccupationalGroup'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Worker Occupational Group id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $workerOccupationalGroup = $this->WorkerOccupationalGroups->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $workerOccupationalGroup = $this->WorkerOccupationalGroups->patchEntity($workerOccupationalGroup, $this->request->getData());
            if ($this->WorkerOccupationalGroups->save($workerOccupationalGroup)) {
                $this->Flash->success(__('The worker occupational group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The worker occupational group could not be saved. Please, try again.'));
        }
        $this->set(compact('workerOccupationalGroup'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Worker Occupational Group id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $workerOccupationalGroup = $this->WorkerOccupationalGroups->get($id);
        if ($this->WorkerOccupationalGroups->delete($workerOccupationalGroup)) {
            $this->Flash->success(__('The worker occupational group has been deleted.'));
        } else {
            $this->Flash->error(__('The worker occupational group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getList()
    {
        $this->getRequest()->allowMethod("GET");
        $worker_occupational_groups = $this->WorkerOccupationalGroups->find('all');

        $this->set(compact('worker_occupational_groups'));
        $this->viewBuilder()->setOption('serialize', true);
    }
}
