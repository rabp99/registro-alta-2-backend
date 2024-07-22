<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * HistorialConsumibles Controller
 *
 * @property \App\Model\Table\HistorialConsumiblesTable $HistorialConsumibles
 * @method \App\Model\Entity\HistorialConsumible[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HistorialConsumiblesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Consumibles', 'Entregas'],
        ];
        $historialConsumibles = $this->paginate($this->HistorialConsumibles);

        $this->set(compact('historialConsumibles'));
    }

    /**
     * View method
     *
     * @param string|null $id Historial Consumible id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $historialConsumible = $this->HistorialConsumibles->get($id, [
            'contain' => ['Consumibles', 'Entregas'],
        ]);

        $this->set(compact('historialConsumible'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $historialConsumible = $this->HistorialConsumibles->newEmptyEntity();
        if ($this->request->is('post')) {
            $historialConsumible = $this->HistorialConsumibles->patchEntity($historialConsumible, $this->request->getData());
            if ($this->HistorialConsumibles->save($historialConsumible)) {
                $this->Flash->success(__('The historial consumible has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The historial consumible could not be saved. Please, try again.'));
        }
        $consumibles = $this->HistorialConsumibles->Consumibles->find('list', ['limit' => 200]);
        $entregas = $this->HistorialConsumibles->Entregas->find('list', ['limit' => 200]);
        $this->set(compact('historialConsumible', 'consumibles', 'entregas'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Historial Consumible id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $historialConsumible = $this->HistorialConsumibles->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $historialConsumible = $this->HistorialConsumibles->patchEntity($historialConsumible, $this->request->getData());
            if ($this->HistorialConsumibles->save($historialConsumible)) {
                $this->Flash->success(__('The historial consumible has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The historial consumible could not be saved. Please, try again.'));
        }
        $consumibles = $this->HistorialConsumibles->Consumibles->find('list', ['limit' => 200]);
        $entregas = $this->HistorialConsumibles->Entregas->find('list', ['limit' => 200]);
        $this->set(compact('historialConsumible', 'consumibles', 'entregas'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Historial Consumible id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $historialConsumible = $this->HistorialConsumibles->get($id);
        if ($this->HistorialConsumibles->delete($historialConsumible)) {
            $this->Flash->success(__('The historial consumible has been deleted.'));
        } else {
            $this->Flash->error(__('The historial consumible could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
