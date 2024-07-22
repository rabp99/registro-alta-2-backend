<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Preguntas Controller
 *
 * @property \App\Model\Table\PreguntasTable $Preguntas
 * @method \App\Model\Entity\Pregunta[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PreguntasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Grupos', 'Estados'],
        ];
        $preguntas = $this->paginate($this->Preguntas);

        $this->set(compact('preguntas'));
    }

    /**
     * View method
     *
     * @param string|null $id Pregunta id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pregunta = $this->Preguntas->get($id, [
            'contain' => ['Grupos', 'Estados'],
        ]);

        $this->set(compact('pregunta'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pregunta = $this->Preguntas->newEmptyEntity();
        if ($this->request->is('post')) {
            $pregunta = $this->Preguntas->patchEntity($pregunta, $this->request->getData());
            if ($this->Preguntas->save($pregunta)) {
                $this->Flash->success(__('The pregunta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pregunta could not be saved. Please, try again.'));
        }
        $grupos = $this->Preguntas->Grupos->find('list', ['limit' => 200]);
        $estados = $this->Preguntas->Estados->find('list', ['limit' => 200]);
        $this->set(compact('pregunta', 'grupos', 'estados'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pregunta id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pregunta = $this->Preguntas->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pregunta = $this->Preguntas->patchEntity($pregunta, $this->request->getData());
            if ($this->Preguntas->save($pregunta)) {
                $this->Flash->success(__('The pregunta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pregunta could not be saved. Please, try again.'));
        }
        $grupos = $this->Preguntas->Grupos->find('list', ['limit' => 200]);
        $estados = $this->Preguntas->Estados->find('list', ['limit' => 200]);
        $this->set(compact('pregunta', 'grupos', 'estados'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pregunta id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pregunta = $this->Preguntas->get($id);
        if ($this->Preguntas->delete($pregunta)) {
            $this->Flash->success(__('The pregunta has been deleted.'));
        } else {
            $this->Flash->error(__('The pregunta could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
