<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ReutilizablesSolicitudesDetalles Controller
 *
 * @property \App\Model\Table\ReutilizablesSolicitudesDetallesTable $ReutilizablesSolicitudesDetalles
 * @method \App\Model\Entity\ReutilizablesSolicitudesDetalle[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReutilizablesSolicitudesDetallesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event) {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['findEntregadosSalida', 'devolver', 'devolverEnSalida']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Solicitudes', 'Reutilizables', 'Estados'],
        ];
        $reutilizablesSolicitudesDetalles = $this->paginate($this->ReutilizablesSolicitudesDetalles);

        $this->set(compact('reutilizablesSolicitudesDetalles'));
    }

    /**
     * View method
     *
     * @param string|null $id Reutilizables Solicitudes Detalle id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reutilizablesSolicitudesDetalle = $this->ReutilizablesSolicitudesDetalles->get($id, [
            'contain' => ['Solicitudes', 'Reutilizables', 'Estados'],
        ]);

        $this->set(compact('reutilizablesSolicitudesDetalle'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reutilizablesSolicitudesDetalle = $this->ReutilizablesSolicitudesDetalles->newEmptyEntity();
        if ($this->request->is('post')) {
            $reutilizablesSolicitudesDetalle = $this->ReutilizablesSolicitudesDetalles->patchEntity($reutilizablesSolicitudesDetalle, $this->request->getData());
            if ($this->ReutilizablesSolicitudesDetalles->save($reutilizablesSolicitudesDetalle)) {
                $this->Flash->success(__('The reutilizables solicitudes detalle has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reutilizables solicitudes detalle could not be saved. Please, try again.'));
        }
        $solicitudes = $this->ReutilizablesSolicitudesDetalles->Solicitudes->find('list', ['limit' => 200]);
        $reutilizables = $this->ReutilizablesSolicitudesDetalles->Reutilizables->find('list', ['limit' => 200]);
        $estados = $this->ReutilizablesSolicitudesDetalles->Estados->find('list', ['limit' => 200]);
        $this->set(compact('reutilizablesSolicitudesDetalle', 'solicitudes', 'reutilizables', 'estados'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reutilizables Solicitudes Detalle id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reutilizablesSolicitudesDetalle = $this->ReutilizablesSolicitudesDetalles->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reutilizablesSolicitudesDetalle = $this->ReutilizablesSolicitudesDetalles->patchEntity($reutilizablesSolicitudesDetalle, $this->request->getData());
            if ($this->ReutilizablesSolicitudesDetalles->save($reutilizablesSolicitudesDetalle)) {
                $this->Flash->success(__('The reutilizables solicitudes detalle has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reutilizables solicitudes detalle could not be saved. Please, try again.'));
        }
        $solicitudes = $this->ReutilizablesSolicitudesDetalles->Solicitudes->find('list', ['limit' => 200]);
        $reutilizables = $this->ReutilizablesSolicitudesDetalles->Reutilizables->find('list', ['limit' => 200]);
        $estados = $this->ReutilizablesSolicitudesDetalles->Estados->find('list', ['limit' => 200]);
        $this->set(compact('reutilizablesSolicitudesDetalle', 'solicitudes', 'reutilizables', 'estados'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reutilizables Solicitudes Detalle id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reutilizablesSolicitudesDetalle = $this->ReutilizablesSolicitudesDetalles->get($id);
        if ($this->ReutilizablesSolicitudesDetalles->delete($reutilizablesSolicitudesDetalle)) {
            $this->Flash->success(__('The reutilizables solicitudes detalle has been deleted.'));
        } else {
            $this->Flash->error(__('The reutilizables solicitudes detalle could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * Find Entregados method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function findEntregados() {
        $dni_medico = $this->getRequest()->getParam('dni_medico');
        $solicitudesTable = $this->getTableLocator()->get('Solicitudes');
        $message = "";
        
        $profesional = $solicitudesTable->findByProgramacionDniMedico($dni_medico)->first()->profesional ?? null;

        $reutilizablesSolicitudesDetalles = $this->ReutilizablesSolicitudesDetalles
            ->find()
            ->contain(["Reutilizables" => ["Tipos"]])
            ->where([
                'ReutilizablesSolicitudesDetalles.dni_medico' => $dni_medico,
                'ReutilizablesSolicitudesDetalles.estado_id' => 4
            ])->toArray();
        
        if (empty($profesional) || sizeof($reutilizablesSolicitudesDetalles)) {
            $message = "No se encontraron solicitudes para este personal";
        }
        
        $this->set(compact("reutilizablesSolicitudesDetalles", "profesional", "message"));
        $this->viewBuilder()->setOption('serialize', true);
    }
    
    /**
     * Find Entregados method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function findEntregadosVestidores() {
        $dni_medico = $this->getRequest()->getParam('dni_medico');
        $solicitudesTable = $this->getTableLocator()->get('Solicitudes');
        $message = "";
        
        $profesional = $solicitudesTable->findByProgramacionDniMedico($dni_medico)->first()->profesional ?? null;

        $reutilizablesSolicitudesDetalles = $this->ReutilizablesSolicitudesDetalles
            ->find()
            ->contain(["Reutilizables" => ["Tipos"]])
            ->where([
                'ReutilizablesSolicitudesDetalles.dni_medico' => $dni_medico,
                'ReutilizablesSolicitudesDetalles.estado_id' => 4
            ])->toArray();
        
        if (empty($profesional) || sizeof($reutilizablesSolicitudesDetalles)) {
            $message = "No se encontraron solicitudes para este personal";
        }
        
        $this->set(compact("reutilizablesSolicitudesDetalles", "profesional", "message"));
        $this->viewBuilder()->setOption('serialize', true);
    }
    
    /**
     * Find Entregados method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function devolver() {
        $reutilizablesSolicitudesDetalles = $this->getRequest()->getData('reutilizables_solicitudes_detalles');
        
        $result = $this->Authentication->getResult();
        $user_id = $result->getData()["id"];
        
        try {
            $this->ReutilizablesSolicitudesDetalles->getConnection()->begin();
            foreach ($reutilizablesSolicitudesDetalles as $reutilizablesSolicitudesDetalle) {
                $reutilizable = $this->ReutilizablesSolicitudesDetalles->Reutilizables
                    ->get($reutilizablesSolicitudesDetalle['reutilizable_id']);
                $reutilizable->estado_id = 7;
                $this->ReutilizablesSolicitudesDetalles->Reutilizables->saveOrFail($reutilizable);

                $reutilizablesSolicitudesDetalle = $this->ReutilizablesSolicitudesDetalles->get($reutilizablesSolicitudesDetalle['id']);

                $reutilizablesSolicitudesDetalle->fecha_devolucion = date('Y-m-d H:i:s');
                $reutilizablesSolicitudesDetalle->estado_id = 9;
                $reutilizablesSolicitudesDetalle->user_registro_devolucion_id = $user_id;

                $this->ReutilizablesSolicitudesDetalles->saveOrFail($reutilizablesSolicitudesDetalle);
            }
            $message = 'Se registró la devolución correctamente';
            $this->ReutilizablesSolicitudesDetalles->getConnection()->commit();
        } catch (Exception $ex) {
            $message = 'No se pudo registrar la devolución';
            $this->setResponse($this->response->withStatus(500));
            $this->ReutilizablesSolicitudesDetalles->getConnection()->rollback();
        } finally {
            $this->set(compact('message'));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }
    
    public function devolverEnSalida() {
        $reutilizablesSolicitudesDetalles = $this->getRequest()->getData('reutilizables_solicitudes_detalles');
        
        try {
            $this->ReutilizablesSolicitudesDetalles->getConnection()->begin();
            foreach ($reutilizablesSolicitudesDetalles as $reutilizablesSolicitudesDetalle) {
                $reutilizable = $this->ReutilizablesSolicitudesDetalles->Reutilizables
                    ->get($reutilizablesSolicitudesDetalle['reutilizable_id']);
                $reutilizable->estado_id = 12;
                $this->ReutilizablesSolicitudesDetalles->Reutilizables->saveOrFail($reutilizable);

                $reutilizablesSolicitudesDetalle = $this->ReutilizablesSolicitudesDetalles->get($reutilizablesSolicitudesDetalle['id']);

                $reutilizablesSolicitudesDetalle->fecha_vestuario = date('Y-m-d H:i:s');
                $reutilizablesSolicitudesDetalle->estado_id = 12;

                $this->ReutilizablesSolicitudesDetalles->saveOrFail($reutilizablesSolicitudesDetalle);
            }
            $message = 'Se registró la devolución correctamente';
            $this->ReutilizablesSolicitudesDetalles->getConnection()->commit();
        } catch (Exception $ex) {
            $message = 'No se pudo registrar la devolución';
            $this->setResponse($this->response->withStatus(500));
            $this->ReutilizablesSolicitudesDetalles->getConnection()->rollback();
        } finally {
            $this->set(compact('message'));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }
    
    /**
     * Find En Vestidores method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function findEnVestidores() {
        $reutilizablesSolicitudesDetalles = $this->ReutilizablesSolicitudesDetalles
            ->find()
            ->contain(["Reutilizables" => ["Tipos"]])
            ->where([
                'ReutilizablesSolicitudesDetalles.estado_id' => 12
            ])->order(['Reutilizables.codigo'])
            ->toArray();
        
        $this->set(compact("reutilizablesSolicitudesDetalles"));
        $this->viewBuilder()->setOption('serialize', true);
    }
    
    /**
     * Find En Lavanderia method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function findEnLavanderia() {
        $reutilizablesSolicitudesDetalles = $this->ReutilizablesSolicitudesDetalles
            ->find()
            ->contain(["Reutilizables" => ["Tipos"]])
            ->where([
                'ReutilizablesSolicitudesDetalles.estado_id' => 13
            ])->toArray();
        
        $this->set(compact("reutilizablesSolicitudesDetalles"));
        $this->viewBuilder()->setOption('serialize', true);
    }
    
    /**
     * Find Entregados method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function findEntregadosSalida() {
        $dni_medico = $this->getRequest()->getParam('dni_medico');
        
        $reutilizablesSolicitudesDetalles = $this->ReutilizablesSolicitudesDetalles
            ->find()
            ->contain(["Solicitudes", "Reutilizables" => ["Tipos" => function ($q) {
                return $q->where(['Tipos.flag_salida' => 1]);
            }]])
            ->where([
                'ReutilizablesSolicitudesDetalles.dni_medico' => $dni_medico,
                'ReutilizablesSolicitudesDetalles.estado_id' => 4
            ]);
        
        $this->set(compact("reutilizablesSolicitudesDetalles"));
        $this->viewBuilder()->setOption('serialize', true);
    }
        
    /**
     * Registrar en Vestuario method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function registrarEnVestidores() {
        $reutilizablesSolicitudesDetalles = $this->getRequest()->getData('reutilizables_solicitudes_detalles');
        
        $result = $this->Authentication->getResult();
        $user_id = $result->getData()["id"];
        
        try {
            $this->ReutilizablesSolicitudesDetalles->getConnection()->begin();
            foreach ($reutilizablesSolicitudesDetalles as $reutilizablesSolicitudesDetalle) {
                $reutilizable = $this->ReutilizablesSolicitudesDetalles->Reutilizables
                    ->get($reutilizablesSolicitudesDetalle['reutilizable_id']);
                $reutilizable->estado_id = 12;
                $this->ReutilizablesSolicitudesDetalles->Reutilizables->saveOrFail($reutilizable);

                $reutilizablesSolicitudesDetalle = $this->ReutilizablesSolicitudesDetalles->get($reutilizablesSolicitudesDetalle['id']);

                $reutilizablesSolicitudesDetalle->fecha_vestuario = date('Y-m-d H:i:s');
                $reutilizablesSolicitudesDetalle->estado_id = 12;
                $reutilizablesSolicitudesDetalle->user_registro_vestuario_id = $user_id;

                $this->ReutilizablesSolicitudesDetalles->saveOrFail($reutilizablesSolicitudesDetalle);
            }
            $message = 'Se registró el ingreso a vestidores correctamente';
            $this->ReutilizablesSolicitudesDetalles->getConnection()->commit();
        } catch (Exception $ex) {
            $message = 'No se pudo registrar el ingreso a vestidores';
            $this->setResponse($this->response->withStatus(500));
            $this->ReutilizablesSolicitudesDetalles->getConnection()->rollback();
        } finally {
            $this->set(compact('message'));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }
    
    /**
     * Registrar en Lavanderia method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function registrarEnLavanderia() {
        $reutilizablesSolicitudesDetalles = $this->getRequest()->getData('reutilizables_solicitudes_detalles');
        
        $result = $this->Authentication->getResult();
        $user_id = $result->getData()["id"];
        
        try {
            $this->ReutilizablesSolicitudesDetalles->getConnection()->begin();
            foreach ($reutilizablesSolicitudesDetalles as $reutilizablesSolicitudesDetalle) {
                $reutilizable = $this->ReutilizablesSolicitudesDetalles->Reutilizables
                    ->get($reutilizablesSolicitudesDetalle['reutilizable_id']);
                $reutilizable->estado_id = 13;
                $this->ReutilizablesSolicitudesDetalles->Reutilizables->saveOrFail($reutilizable);

                $reutilizablesSolicitudesDetalle = $this->ReutilizablesSolicitudesDetalles->get($reutilizablesSolicitudesDetalle['id']);

                $reutilizablesSolicitudesDetalle->fecha_lavanderia = date('Y-m-d H:i:s');
                $reutilizablesSolicitudesDetalle->estado_id = 13;
                $reutilizablesSolicitudesDetalle->user_registro_lavanderia_id = $user_id;

                $this->ReutilizablesSolicitudesDetalles->saveOrFail($reutilizablesSolicitudesDetalle);
            }
            $message = 'Se registró el ingreso a vestidores correctamente';
            $this->ReutilizablesSolicitudesDetalles->getConnection()->commit();
        } catch (Exception $ex) {
            $message = 'No se pudo registrar el ingreso a vestidores';
            $this->setResponse($this->response->withStatus(500));
            $this->ReutilizablesSolicitudesDetalles->getConnection()->rollback();
        } finally {
            $this->set(compact('message'));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }
    
    /**
     * Registrar Devolución method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function registrarDevolucion() {
        $reutilizablesSolicitudesDetalles = $this->getRequest()->getData('reutilizables_solicitudes_detalles');
        
        $result = $this->Authentication->getResult();
        $user_id = $result->getData()["id"];
        
        try {
            $this->ReutilizablesSolicitudesDetalles->getConnection()->begin();
            foreach ($reutilizablesSolicitudesDetalles as $reutilizablesSolicitudesDetalle) {
                $reutilizable = $this->ReutilizablesSolicitudesDetalles->Reutilizables
                    ->get($reutilizablesSolicitudesDetalle['reutilizable_id']);
                $reutilizable->estado_id = 7;
                $this->ReutilizablesSolicitudesDetalles->Reutilizables->saveOrFail($reutilizable);

                $reutilizablesSolicitudesDetalle = $this->ReutilizablesSolicitudesDetalles->get($reutilizablesSolicitudesDetalle['id']);

                $reutilizablesSolicitudesDetalle->fecha_devolucion = date('Y-m-d H:i:s');
                $reutilizablesSolicitudesDetalle->estado_id = 9;
                $reutilizablesSolicitudesDetalle->user_registro_devolucion_id = $user_id;

                $this->ReutilizablesSolicitudesDetalles->saveOrFail($reutilizablesSolicitudesDetalle);
            }
            $message = 'Se registró la devolución correctamente';
            $this->ReutilizablesSolicitudesDetalles->getConnection()->commit();
        } catch (Exception $ex) {
            $message = 'No se pudo registrar la devolución';
            $this->setResponse($this->response->withStatus(500));
            $this->ReutilizablesSolicitudesDetalles->getConnection()->rollback();
        } finally {
            $this->set(compact('message'));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }
}