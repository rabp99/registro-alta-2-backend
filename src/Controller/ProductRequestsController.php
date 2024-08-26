<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\InternalErrorException;


/**
 * ProductRequests Controller
 *
 * @property \App\Model\Table\ProductRequestsTable $ProductRequests
 * @method \App\Model\Entity\ProductRequest[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductRequestsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['add']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['WorkAreas', 'Users'],
        ];
        $productRequests = $this->paginate($this->ProductRequests);

        $this->set(compact('productRequests'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Request id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productRequest = $this->ProductRequests->get($id, [
            'contain' => ['WorkAreas', 'Users'],
        ]);

        $this->set(compact('productRequest'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->getRequest()->allowMethod("POST");
        $this->viewBuilder()->setOption('serialize', true);

        $productRequest = $this->ProductRequests->create($this->getRequest()->getData());

        if ($this->ProductRequests->save($productRequest, ['associated' => ['KitsProductRequests.ProductRequestDetails']])) {
            $message = 'La solicitud fue registrada satisfactoriamente';
            $this->set(compact('productRequest', 'message'));
            return;
        } else {
            throw new InternalErrorException(__('La solicitud no fue registrada satisfactoriamente'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Request id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productRequest = $this->ProductRequests->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productRequest = $this->ProductRequests->patchEntity($productRequest, $this->request->getData());
            if ($this->ProductRequests->save($productRequest)) {
                $this->Flash->success(__('The product request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product request could not be saved. Please, try again.'));
        }
        $workAreas = $this->ProductRequests->WorkAreas->find('list', ['limit' => 200]);
        $users = $this->ProductRequests->Users->find('list', ['limit' => 200]);
        $this->set(compact('productRequest', 'workAreas', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Request id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productRequest = $this->ProductRequests->get($id);
        if ($this->ProductRequests->delete($productRequest)) {
            $this->Flash->success(__('The product request has been deleted.'));
        } else {
            $this->Flash->error(__('The product request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getActiveByWorker()
    {
        $this->getRequest()->allowMethod("GET");
        $this->viewBuilder()->setOption('serialize', true);

        $documentType = $this->getRequest()->getParam("document_type");
        $documentNumber = $this->getRequest()->getParam("document_number");

        $productRequests = $this->ProductRequests->findByDocumentTypeAndDocumentNumber(
            $documentType,
            $documentNumber
        )
            ->where(["ProductRequests.attention_date IS" => null])
            ->contain([
                "KitsProductRequests" => [
                    "Kits",
                    "ProductRequestDetails" => ["Products"]
                ],
                "WorkAreas" => ["Workplaces"]
            ]);

        $this->set(compact("productRequests"));
    }
}
