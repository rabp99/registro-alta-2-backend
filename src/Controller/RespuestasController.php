<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Respuestas Controller
 *
 * @property \App\Model\Table\RespuestasTable $Respuestas
 * @method \App\Model\Entity\Respuesta[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RespuestasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Cuestionarios', 'Preguntas'],
        ];
        $respuestas = $this->paginate($this->Respuestas);

        $this->set(compact('respuestas'));
    }

    /**
     * View method
     *
     * @param string|null $id Respuesta id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $respuesta = $this->Respuestas->get($id, [
            'contain' => ['Cuestionarios', 'Preguntas'],
        ]);

        $this->set(compact('respuesta'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $respuesta = $this->Respuestas->newEmptyEntity();
        if ($this->request->is('post')) {
            $respuesta = $this->Respuestas->patchEntity($respuesta, $this->request->getData());
            if ($this->Respuestas->save($respuesta)) {
                $this->Flash->success(__('The respuesta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The respuesta could not be saved. Please, try again.'));
        }
        $cuestionarios = $this->Respuestas->Cuestionarios->find('list', ['limit' => 200]);
        $preguntas = $this->Respuestas->Preguntas->find('list', ['limit' => 200]);
        $this->set(compact('respuesta', 'cuestionarios', 'preguntas'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Respuesta id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $respuesta = $this->Respuestas->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $respuesta = $this->Respuestas->patchEntity($respuesta, $this->request->getData());
            if ($this->Respuestas->save($respuesta)) {
                $this->Flash->success(__('The respuesta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The respuesta could not be saved. Please, try again.'));
        }
        $cuestionarios = $this->Respuestas->Cuestionarios->find('list', ['limit' => 200]);
        $preguntas = $this->Respuestas->Preguntas->find('list', ['limit' => 200]);
        $this->set(compact('respuesta', 'cuestionarios', 'preguntas'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Respuesta id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $respuesta = $this->Respuestas->get($id);
        if ($this->Respuestas->delete($respuesta)) {
            $this->Flash->success(__('The respuesta has been deleted.'));
        } else {
            $this->Flash->error(__('The respuesta could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
