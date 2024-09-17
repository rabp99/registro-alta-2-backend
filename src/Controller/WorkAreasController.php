<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * WorkAreas Controller
 *
 * @method \App\Model\Entity\WorkArea[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WorkAreasController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['getListByWorkplaceAndWorker']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $workAreas = $this->paginate($this->WorkAreas);

        $this->set(compact('workAreas'));
    }

    /**
     * View method
     *
     * @param string|null $id Work Area id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $workArea = $this->WorkAreas->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('workArea'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $workArea = $this->WorkAreas->newEmptyEntity();
        if ($this->request->is('post')) {
            $workArea = $this->WorkAreas->patchEntity($workArea, $this->request->getData());
            if ($this->WorkAreas->save($workArea)) {
                $this->Flash->success(__('The work area has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The work area could not be saved. Please, try again.'));
        }
        $this->set(compact('workArea'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Work Area id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $workArea = $this->WorkAreas->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $workArea = $this->WorkAreas->patchEntity($workArea, $this->request->getData());
            if ($this->WorkAreas->save($workArea)) {
                $this->Flash->success(__('The work area has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The work area could not be saved. Please, try again.'));
        }
        $this->set(compact('workArea'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Work Area id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $workArea = $this->WorkAreas->get($id);
        if ($this->WorkAreas->delete($workArea)) {
            $this->Flash->success(__('The work area has been deleted.'));
        } else {
            $this->Flash->error(__('The work area could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getListByWorkplaceAndWorker()
    {
        $this->getRequest()->allowMethod("GET");
        $this->viewBuilder()->setOption('serialize', true);

        $this->loadModel("Workers");

        $workplaceId = $this->getRequest()->getParam("workplace_id");
        $workerDocumentType = $this->getRequest()->getParam("worker_document_type");
        $workerDocumentNumber = $this->getRequest()->getParam("worker_document_number");
        $worker = $this->Workers->get([$workerDocumentType, $workerDocumentNumber]);

        switch (true) {
            case $worker->type_asistencial && $worker->type_administrativo:
                $workAreas = $this->WorkAreas->find()
                    ->where([
                        'WorkAreas.workplace_id' => $workplaceId,
                        'OR' => [
                            'WorkAreas.type_asistencial' => true,
                            'WorkAreas.type_administrativo' => true,
                        ]
                    ]);
                break;
            case $worker->type_asistencial && !$worker->type_administrativo:
                $workAreas = $this->WorkAreas->findByWorkplaceIdAndTypeAsistencial($workplaceId, true);
                break;
            case $worker->type_administrativo && !$worker->type_asistencial:
                $workAreas = $this->WorkAreas->findByWorkplaceIdAndTypeAdministrativo($workplaceId, true);
                break;
        }

        $this->set(compact('workAreas'));
    }
}
