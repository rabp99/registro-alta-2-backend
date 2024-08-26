<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * WorkAreaDetails Controller
 *
 * @method \App\Model\Entity\WorkAreaDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WorkAreaDetailsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['getByWorkArea']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $workAreaDetails = $this->paginate($this->WorkAreaDetails);

        $this->set(compact('workAreaDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Work Area Detail id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $workAreaDetail = $this->WorkAreaDetails->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('workAreaDetail'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $workAreaDetail = $this->WorkAreaDetails->newEmptyEntity();
        if ($this->request->is('post')) {
            $workAreaDetail = $this->WorkAreaDetails->patchEntity($workAreaDetail, $this->request->getData());
            if ($this->WorkAreaDetails->save($workAreaDetail)) {
                $this->Flash->success(__('The work area detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The work area detail could not be saved. Please, try again.'));
        }
        $this->set(compact('workAreaDetail'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Work Area Detail id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $workAreaDetail = $this->WorkAreaDetails->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $workAreaDetail = $this->WorkAreaDetails->patchEntity($workAreaDetail, $this->request->getData());
            if ($this->WorkAreaDetails->save($workAreaDetail)) {
                $this->Flash->success(__('The work area detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The work area detail could not be saved. Please, try again.'));
        }
        $this->set(compact('workAreaDetail'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Work Area Detail id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $workAreaDetail = $this->WorkAreaDetails->get($id);
        if ($this->WorkAreaDetails->delete($workAreaDetail)) {
            $this->Flash->success(__('The work area detail has been deleted.'));
        } else {
            $this->Flash->error(__('The work area detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getByWorkArea()
    {
        $this->getRequest()->allowMethod("GET");
        $this->viewBuilder()->setOption('serialize', true);

        $workAreaId = $this->getRequest()->getParam("worker_area_id");

        $workAreaDetails = $this->WorkAreaDetails->find()
            ->where(["WorkAreaDetails.work_area_id" => $workAreaId]);

        $this->set(compact('workAreaDetails'));
    }
}
