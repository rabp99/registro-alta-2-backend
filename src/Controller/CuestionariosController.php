<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Cuestionarios Controller
 *
 * @property \App\Model\Table\CuestionariosTable $Cuestionarios
 * @method \App\Model\Entity\Cuestionario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CuestionariosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $cuestionarios = $this->paginate($this->Cuestionarios);

        $this->set(compact('cuestionarios'));
    }

    /**
     * View method
     *
     * @param string|null $id Cuestionario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cuestionario = $this->Cuestionarios->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('cuestionario'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cuestionario = $this->Cuestionarios->newEmptyEntity();
        if ($this->request->is('post')) {
            $cuestionario = $this->Cuestionarios->patchEntity($cuestionario, $this->request->getData());
            if ($this->Cuestionarios->save($cuestionario)) {
                $this->Flash->success(__('The cuestionario has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cuestionario could not be saved. Please, try again.'));
        }
        $this->set(compact('cuestionario'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cuestionario id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cuestionario = $this->Cuestionarios->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cuestionario = $this->Cuestionarios->patchEntity($cuestionario, $this->request->getData());
            if ($this->Cuestionarios->save($cuestionario)) {
                $this->Flash->success(__('The cuestionario has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cuestionario could not be saved. Please, try again.'));
        }
        $this->set(compact('cuestionario'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cuestionario id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cuestionario = $this->Cuestionarios->get($id);
        if ($this->Cuestionarios->delete($cuestionario)) {
            $this->Flash->success(__('The cuestionario has been deleted.'));
        } else {
            $this->Flash->error(__('The cuestionario could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
