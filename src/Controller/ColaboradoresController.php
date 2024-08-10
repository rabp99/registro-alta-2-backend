<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\BadRequestException;

/**
 * Colaboradores Controller
 *
 * @property \App\Model\Table\ColaboradoresTable $Colaboradores
 * @method \App\Model\Entity\Colaboradore[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ColaboradoresController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['findByDni', 'getEnabled']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->getRequest()->allowMethod("GET");
        $dniMedico = $this->request->getQuery('dni_medico');
        $itemsPerPage = $this->request->getQuery('itemsPerPage');

        $query = $this->Colaboradores->find()
            ->contain(['Estados', 'GruposOcupacionales'])
            ->order(['Colaboradores.dni_medico']);

        if ($dniMedico) {
            $query->where(['Colaboradores.dni_medico LIKE' => "%$dniMedico%"]);
        }

        $count = $query->count();
        if (!$itemsPerPage) {
            $itemsPerPage = $count;
        }
        $colaboradores = $this->paginate($query, [
            'limit' => $itemsPerPage
        ]);
        $paginate = $this->request->getAttribute('paging')['Colaboradores'];
        $pagination = [
            'totalItems' => $paginate['count'],
            'itemsPerPage' =>  $paginate['perPage']
        ];

        $this->set(compact('colaboradores', 'pagination', 'count'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function getEnabled()
    {
        $this->getRequest()->allowMethod("GET");
        $colaboradores = $this->Colaboradores->find()
            ->where(['Colaboradores.estado_id' => 1]);

        $this->set(compact('colaboradores'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    /**
     * View method
     *
     * @param string|null $id Colaboradore id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $colaboradore = $this->Colaboradores->get($id, [
            'contain' => ['Estados'],
        ]);

        $this->set(compact('colaboradore'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->getRequest()->allowMethod("POST");
        $colaborador = $this->Colaboradores->newEntity($this->getRequest()->getData());
        $colaborador->estado_id = 1;
        $errors = "";

        if ($this->Colaboradores->save($colaborador)) {
            $message = 'El colaborador fue registrado correctamente';
        } else {
            $message = 'El colaborador no fue registrado correctamente';
            $this->setResponse($this->getResponse()->withStatus(500));
            $errors = $colaborador->getErrors();
        }

        $this->set(compact('colaborador', "message", "errors"));
        $this->viewBuilder()->setOption('serialize', true);
    }

    /**
     * Edit method
     *
     * @param string|null $id Colaboradore id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $colaboradore = $this->Colaboradores->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $colaboradore = $this->Colaboradores->patchEntity($colaboradore, $this->request->getData());
            if ($this->Colaboradores->save($colaboradore)) {
                $this->Flash->success(__('The colaboradore has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The colaboradore could not be saved. Please, try again.'));
        }
        $estados = $this->Colaboradores->Estados->find('list', ['limit' => 200]);
        $this->set(compact('colaboradore', 'estados'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Colaboradore id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $colaboradore = $this->Colaboradores->get($id);
        if ($this->Colaboradores->delete($colaboradore)) {
            $this->Flash->success(__('The colaboradore has been deleted.'));
        } else {
            $this->Flash->error(__('The colaboradore could not be deleted. Please, try again.'));
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
    public function findByDni()
    {
        $this->getRequest()->allowMethod("GET");
        $dni = $this->getRequest()->getParam('dni');

        $colaborador = $this->Colaboradores->find()
            ->where([
                'Colaboradores.nro_documento' => $dni,
                'Colaboradores.estado_id <>' => 2,
            ])->first();

        $this->set(compact('colaborador'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    public function checkColaboradorProgramadoHoy()
    {
        $dni_medico = $this->getRequest()->getParam('dni_medico');
        try {
            $colaborador = $this->Colaboradores->get($dni_medico, ["contain" => "GruposOcupacionales"]);
        } catch (\Throwable $th) {
            throw new BadRequestException(__('No se encontró un colaborador con este número de documento.'));
        }

        $programacionesCount = $this->Colaboradores->Programaciones->find()->where([
            'Programaciones.dni_medico' => $dni_medico,
            'Programaciones.fecha_programacion' => date('Y-m-d'),
            'Programaciones.estado_id' => 1
        ])->count();

        if (!$programacionesCount) {
            throw new BadRequestException(__('No se encontraron programaciones disponibles.'));
        }

        $turnos = [];
        if ($programacionesCount === 1) {
            $turnos = $this->Colaboradores->Programaciones->find()
                ->select(['turno'])
                ->where([
                    'Programaciones.dni_medico' => $dni_medico,
                    'Programaciones.fecha_programacion' => date('Y-m-d'),
                    'Programaciones.estado_id' => 1
                ])->first();
        }

        $this->set(compact('colaborador', 'turnos'));
        $this->viewBuilder()->setOption('serialize', true);
    }
}
