<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * GruposOcupacionales Controller
 *
 * @property \App\Model\Table\GruposOcupacionalesTable $GruposOcupacionales
 * @method \App\Model\Entity\GruposOcupacionale[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GruposOcupacionalesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function getAllowShow() {
        $gruposOcupacionales = $this->GruposOcupacionales->find()
            ->where(['GruposOcupacionales.flag_show' => "1"]);
        
        $this->set(compact('gruposOcupacionales'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    /**
     * View method
     *
     * @param string|null $id Grupos Ocupacionale id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $gruposOcupacionale = $this->GruposOcupacionales->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('gruposOcupacionale'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $gruposOcupacionale = $this->GruposOcupacionales->newEmptyEntity();
        if ($this->request->is('post')) {
            $gruposOcupacionale = $this->GruposOcupacionales->patchEntity($gruposOcupacionale, $this->request->getData());
            if ($this->GruposOcupacionales->save($gruposOcupacionale)) {
                $this->Flash->success(__('The grupos ocupacionale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grupos ocupacionale could not be saved. Please, try again.'));
        }
        $this->set(compact('gruposOcupacionale'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Grupos Ocupacionale id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $gruposOcupacionale = $this->GruposOcupacionales->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gruposOcupacionale = $this->GruposOcupacionales->patchEntity($gruposOcupacionale, $this->request->getData());
            if ($this->GruposOcupacionales->save($gruposOcupacionale)) {
                $this->Flash->success(__('The grupos ocupacionale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grupos ocupacionale could not be saved. Please, try again.'));
        }
        $this->set(compact('gruposOcupacionale'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Grupos Ocupacionale id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $gruposOcupacionale = $this->GruposOcupacionales->get($id);
        if ($this->GruposOcupacionales->delete($gruposOcupacionale)) {
            $this->Flash->success(__('The grupos ocupacionale has been deleted.'));
        } else {
            $this->Flash->error(__('The grupos ocupacionale could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
