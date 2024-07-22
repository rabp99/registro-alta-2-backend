<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Consumibles Controller
 *
 * @property \App\Model\Table\ConsumiblesTable $Consumibles
 * @method \App\Model\Entity\Consumible[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ConsumiblesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $this->getRequest()->allowMethod("GET");
           
        $consumibles = $this->Consumibles->find()
            ->contain(['Estados'])
            ->order(['Consumibles.id']);
        
        $this->set(compact('consumibles'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    /**
     * Get Enabled method
     *
     * @return \Cake\Http\Response|null|void Renders get enabled
     */
    public function getEnabled() {
        $consumibles = $this->Consumibles->find()
            ->where(['Consumibles.estado_id' => 1]);

        $this->set(compact('consumibles'));
        $this->viewBuilder()->setOption('serialize', true);
    }
    
    /**
     * View method
     *
     * @param string|null $id Consumible id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $consumible = $this->Consumibles->get($id, [
            'contain' => ['Estados'],
        ]);

        $this->set(compact('consumible'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $consumible = $this->Consumibles->newEmptyEntity();
        if ($this->request->is('post')) {
            $consumible = $this->Consumibles->patchEntity($consumible, $this->request->getData());
            if ($this->Consumibles->save($consumible)) {
                $this->Flash->success(__('The consumible has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consumible could not be saved. Please, try again.'));
        }
        $estados = $this->Consumibles->Estados->find('list', ['limit' => 200]);
        $this->set(compact('consumible', 'estados'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Consumible id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $consumible = $this->Consumibles->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $consumible = $this->Consumibles->patchEntity($consumible, $this->request->getData());
            if ($this->Consumibles->save($consumible)) {
                $this->Flash->success(__('The consumible has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consumible could not be saved. Please, try again.'));
        }
        $estados = $this->Consumibles->Estados->find('list', ['limit' => 200]);
        $this->set(compact('consumible', 'estados'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Consumible id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $consumible = $this->Consumibles->get($id);
        if ($this->Consumibles->delete($consumible)) {
            $this->Flash->success(__('The consumible has been deleted.'));
        } else {
            $this->Flash->error(__('The consumible could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function report() {
        $this->getRequest()->allowMethod("POST");
        $consumible_id = $this->getRequest()->getData('consumible_id');
        $dni = $this->getRequest()->getData('dni');
        $fecha_inicial = $this->request->getData('fecha_inicial');
        $fecha_final = $this->request->getData('fecha_final');
           
        $query = $this->Consumibles->Entregas->find()
            ->order(['Entregas.fecha']);
        
        if ($dni) {
            $query->where([
                'Entregas.nro_documento LIKE' => '%' . $dni . '%'
            ]);
        }
        
        if ($consumible_id) {
            $query->where([
                'Entregas.consumible_id' => $consumible_id
            ]);
        }
        
        if ($fecha_inicial && $fecha_final) {
            $query->where([
                "Entregas.fecha >" => $fecha_inicial,
                "Entregas.fecha <=" => $fecha_final
            ]);
        }
        
        $count = $query->count();
        if (!$itemsPerPage) {
            $itemsPerPage = $count;
        }
        $programaciones = $this->paginate($query, [
            'limit' => $itemsPerPage
        ]);
        $paginate = $this->request->getAttribute('paging')['Programaciones'];
        $pagination = [
            'totalItems' => $paginate['count'],
            'itemsPerPage' =>  $paginate['perPage']
        ];
        
        $this->set(compact('programaciones', 'pagination', 'count'));
        $this->viewBuilder()->setOption('serialize', true);
    }
    
    /**
     * Save Stock method
     *
     * @return \Cake\Http\Response|null|void Renders get enabled
     */
    public function saveStock() {
        $this->getRequest()->allowMethod('POST');
        $consumible_id = $this->getRequest()->getData('consumible_id');
        $new_stock = $this->getRequest()->getData('new_stock');
        $consumible = $this->Consumibles->get($consumible_id);
        $consumible->stock = $new_stock;
        $message = "";
        
        if ($this->Consumibles->save($consumible)) {
            $message = "Se actualizó el stock correctamente";
        } else {
            $message = "No se pudo actualizar el stock";
            $this->setResponse($this->response->withStatus(500));
        }

        $this->set(compact('consumible', 'message'));
        $this->viewBuilder()->setOption('serialize', true);
    }
}