<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Supervisores Controller
 *
 * @property \App\Model\Table\SupervisoresTable $Supervisores
 * @method \App\Model\Entity\Supervisore[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SupervisoresController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event) {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['findByDni', 'getEnabled']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function getEnabled() {
        $supervisores = $this->Supervisores->find()
            ->where(['Supervisores.estado_id' => 1])->order('Supervisores.trabajador');

        $this->set(compact('supervisores'));
        $this->viewBuilder()->setOption('serialize', true);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $this->getRequest()->allowMethod("GET");
        $nroDocumento = $this->request->getQuery('nro_documento');
        $itemsPerPage = $this->request->getQuery('itemsPerPage');
           
        $query = $this->Supervisores->find()
            ->contain(['Estados'])
            ->order(['Supervisores.id']);
        
        if ($nroDocumento) {
            $query->where(['Supervisores.nro_documento LIKE' => "%$nroDocumento%"]);
        }
        
        $count = $query->count();
        if (!$itemsPerPage) {
            $itemsPerPage = $count;
        }
        $supervisores = $this->paginate($query, [
            'limit' => $itemsPerPage
        ]);
        $paginate = $this->request->getAttribute('paging')['Supervisores'];
        $pagination = [
            'totalItems' => $paginate['count'],
            'itemsPerPage' =>  $paginate['perPage']
        ];
        
        $this->set(compact('supervisores', 'pagination', 'count'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    /**
     * View method
     *
     * @param string|null $id Supervisore id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $supervisore = $this->Supervisores->get($id, [
            'contain' => ['Estados'],
        ]);

        $this->set(compact('supervisore'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $this->getRequest()->allowMethod("POST");
        $supervisor = $this->Supervisores->newEntity($this->getRequest()->getData());
        $supervisor->tipo_documento = "DNI";
        $supervisor->estado_id = 1;
        $errors = "";
                
        if ($this->Supervisores->save($supervisor)) {
            $message = 'El supervisor fue registrado correctamente';
        } else {
            $message = 'El supervisor no fue registrado correctamente';
            $this->setResponse($this->getResponse()->withStatus(500));
            $errors = $supervisor->getErrors();
        }
        
        $this->set(compact('supervisor', "message", "errors"));
        $this->viewBuilder()->setOption('serialize', true);
    }

    /**
     * Edit method
     *
     * @param string|null $id Supervisore id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $supervisore = $this->Supervisores->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $supervisore = $this->Supervisores->patchEntity($supervisore, $this->request->getData());
            if ($this->Supervisores->save($supervisore)) {
                $this->Flash->success(__('The supervisore has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supervisore could not be saved. Please, try again.'));
        }
        $estados = $this->Supervisores->Estados->find('list', ['limit' => 200]);
        $this->set(compact('supervisore', 'estados'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Supervisore id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $supervisore = $this->Supervisores->get($id);
        if ($this->Supervisores->delete($supervisore)) {
            $this->Flash->success(__('The supervisore has been deleted.'));
        } else {
            $this->Flash->error(__('The supervisore could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
        
    /**
     * Find By DNI method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Redirects to findByDni.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function findByDni() {
        $this->getRequest()->allowMethod("GET");
        $dni = $this->getRequest()->getQuery('dni');

        $supervisor = $this->Supervisores->find()
            ->where([
                'Supervisores.nro_documento' => $dni,
                'Supervisores.estado_id <>' => 2,
            ])->first();
        
        $this->set(compact('supervisor'));
        $this->viewBuilder()->setOption('serialize', true);
    }
}