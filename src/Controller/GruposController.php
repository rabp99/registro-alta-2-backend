<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Grupos Controller
 *
 * @property \App\Model\Table\GruposTable $Grupos
 * @method \App\Model\Entity\Grupo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GruposController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event) {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['getCuestionario']);
    }
    
    /**
     * Get Cuestionario method
     *
     * @param string|null $id Grupo id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function getCuestionario() {
        $this->request->allowMethod(['get']);
        $grupos = $this->Grupos->find()
            ->contain(['Preguntas']);
        
        $this->set(compact('grupos'));
        $this->viewBuilder()->setOption('serialize', true);
    }
}
