<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Entregas Controller
 *
 * @property \App\Model\Table\EntregasTable $Entregas
 * @method \App\Model\Entity\Entrega[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EntregasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Consumibles'],
        ];
        $entregas = $this->paginate($this->Entregas);

        $this->set(compact('entregas'));
    }

    /**
     * View method
     *
     * @param string|null $id Entrega id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $entrega = $this->Entregas->get($id, [
            'contain' => ['Consumibles'],
        ]);

        $this->set(compact('entrega'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $this->getRequest()->allowMethod('post');
        $entrega = $this->Entregas->newEntity($this->getRequest()->getData());
        $entrega->fecha = date('Y-m-d');
        
        try {
            $this->Entregas->getConnection()->begin();
            
            $errors = null;
            $this->Entregas->saveOrFail($entrega);
            $historialConsumible = $this->Entregas->HistorialConsumibles->newEmptyEntity();
            $historialConsumible->consumible_id = $entrega->consumible_id;
            $historialConsumible->tipo = 'ENTREGA';
            $historialConsumible->fecha_hora = date('Y-m-d h:i');
            $historialConsumible->cantidad = $entrega->cantidad;
            $historialConsumible->entrega_id = $entrega->id;
            $this->Entregas->HistorialConsumibles->saveOrFail($historialConsumible);
            $message = 'La entrega fue registrada correctamente';
            
            $this->Entregas->getConnection()->commit();
        } catch (Exception $ex) {
            $message = 'No se pudo registrar la entrega';
            $errors = $entrega->getErrors();
            $this->setResponse($this->response->withStatus(500));
            $this->Entregas->getConnection()->rollback();
        } finally {
            $this->set(compact('entrega', 'message', 'errors'));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Entrega id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $entrega = $this->Entregas->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $entrega = $this->Entregas->patchEntity($entrega, $this->request->getData());
            if ($this->Entregas->save($entrega)) {
                $this->Flash->success(__('The entrega has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The entrega could not be saved. Please, try again.'));
        }
        $consumibles = $this->Entregas->Consumibles->find('list', ['limit' => 200]);
        $this->set(compact('entrega', 'consumibles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Entrega id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $entrega = $this->Entregas->get($id);
        if ($this->Entregas->delete($entrega)) {
            $this->Flash->success(__('The entrega has been deleted.'));
        } else {
            $this->Flash->error(__('The entrega could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * Delete method
     *
     * @param string|null $id Entrega id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function findEntregas() {
        $this->request->allowMethod('get');
        $dni = $this->getRequest()->getParam('dni');
        $entregas = $this->Entregas->find()
            ->contain(['Consumibles'])
            ->where(['Entregas.nro_documento' => $dni])->limit(5);

        $this->set(compact('entregas'));
        $this->viewBuilder()->setOption('serialize', true);
    }
}
