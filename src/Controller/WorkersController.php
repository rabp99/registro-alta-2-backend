<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Exception;
use PhpParser\Node\Expr\Throw_;
use Throwable;

/**
 * Workers Controller
 *
 * @property \App\Model\Table\WorkersTable $Workers
 * @method \App\Model\Entity\Worker[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WorkersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['findByDocument']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->getRequest()->allowMethod("GET");
        $documentNumber = $this->request->getQuery('document_number');
        $itemsPerPage = $this->request->getQuery('itemsPerPage');

        $query = $this->Workers->find()
            ->contain(['WorkerOccupationalGroups', 'WorkerMedicalSpecialities', 'WorkerConditions'])
            ->order(['Workers.document_type' => 'DESC', 'Workers.document_number' => 'ASC']);

        if ($documentNumber) {
            $query->where(['Workers.document_number LIKE' => "%$documentNumber%"]);
        }

        $count = $query->count();
        if (!$itemsPerPage) {
            $itemsPerPage = $count;
        }

        $workers = $this->paginate($query, [
            'limit' => $itemsPerPage
        ]);

        $paginate = $this->request->getAttribute('paging')['Workers'];
        $pagination = [
            'totalItems' => $paginate['count'],
            'itemsPerPage' =>  $paginate['perPage']
        ];

        $this->set(compact('workers', 'pagination', 'count'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    /**
     * View method
     *
     * @param string|null $id Worker id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $worker = $this->Workers->get($id, [
            'contain' => ['WorkerOccupationalGroups', 'WorkerConditions', 'WorkerMedicalSpecialities'],
        ]);

        $this->set(compact('worker'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->getRequest()->allowMethod("POST");
        $worker = $this->Workers->newEntity($this->getRequest()->getData());
        $errors = [];

        $userTrackable = $this->request->getAttribute('identity');

        if ($this->Workers->save($worker, ['userId' => $userTrackable->getIdentifier()])) {
            $message = 'El colaborador fue registrado correctamente';
        } else {
            $message = 'El colaborador no fue registrado correctamente';
            $this->setResponse($this->getResponse()->withStatus(500));
            $errors = $worker->getErrors();
        }

        $this->set(compact('worker', "message", "errors"));
        $this->viewBuilder()->setOption('serialize', true);
    }

    /**
     * Update method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function update()
    {
        $this->getRequest()->allowMethod("PUT");
        $this->viewBuilder()->setOption('serialize', true);

        $documentType = $this->getRequest()->getParam("document_type");
        $documentNumber = $this->getRequest()->getParam("document_number");

        $worker = $this->Workers->get([$documentType, $documentNumber]);
        $worker = $this->Workers->patchEntity($worker, $this->getRequest()->getData());
        $userTrackable = $this->getRequest()->getAttribute('identity');

        if ($this->Workers->save($worker, ['userId' => $userTrackable->getIdentifier()])) {
            $message = 'El colaborador fue registrado correctamente';
            $this->set(compact('worker', "message"));
            return;
        } else {
            throw new NotFoundException("El colaborador no fue modificado correctamente");
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Worker id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $worker = $this->Workers->get($id);
        if ($this->Workers->delete($worker)) {
            $this->Flash->success(__('The worker has been deleted.'));
        } else {
            $this->Flash->error(__('The worker could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Find by Document method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function findByDocument()
    {
        $this->getRequest()->allowMethod("GET");
        $this->viewBuilder()->setOption('serialize', true);

        $documentType = $this->getRequest()->getParam("document_type");
        $documentNumber = $this->getRequest()->getParam("document_number");

        try {
            $worker = $this->Workers->get([$documentType, $documentNumber], [
                "contain" => ["WorkerOccupationalGroups", "WorkerMedicalSpecialities"]
            ]);
            $this->set(compact('worker'));
        } catch (Exception $ex) {
            throw new NotFoundException("Trabajador no encontrado");
        }
    }
}
