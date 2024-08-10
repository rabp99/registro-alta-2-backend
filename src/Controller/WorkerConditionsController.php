<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * WorkerConditions Controller
 *
 * @property \App\Model\Table\WorkerConditionsTable $WorkerConditions
 * @method \App\Model\Entity\WorkerCondition[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WorkerConditionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $workerConditions = $this->paginate($this->WorkerConditions);

        $this->set(compact('workerConditions'));
    }

    /**
     * View method
     *
     * @param string|null $id Worker Condition id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $workerCondition = $this->WorkerConditions->get($id, [
            'contain' => ['Workers'],
        ]);

        $this->set(compact('workerCondition'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $workerCondition = $this->WorkerConditions->newEmptyEntity();
        if ($this->request->is('post')) {
            $workerCondition = $this->WorkerConditions->patchEntity($workerCondition, $this->request->getData());
            if ($this->WorkerConditions->save($workerCondition)) {
                $this->Flash->success(__('The worker condition has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The worker condition could not be saved. Please, try again.'));
        }
        $this->set(compact('workerCondition'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Worker Condition id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $workerCondition = $this->WorkerConditions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $workerCondition = $this->WorkerConditions->patchEntity($workerCondition, $this->request->getData());
            if ($this->WorkerConditions->save($workerCondition)) {
                $this->Flash->success(__('The worker condition has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The worker condition could not be saved. Please, try again.'));
        }
        $this->set(compact('workerCondition'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Worker Condition id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $workerCondition = $this->WorkerConditions->get($id);
        if ($this->WorkerConditions->delete($workerCondition)) {
            $this->Flash->success(__('The worker condition has been deleted.'));
        } else {
            $this->Flash->error(__('The worker condition could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getList()
    {
        $this->getRequest()->allowMethod("GET");
        $worker_conditions = $this->WorkerConditions->find('all');

        $this->set(compact('worker_conditions'));
        $this->viewBuilder()->setOption('serialize', true);
    }
}
