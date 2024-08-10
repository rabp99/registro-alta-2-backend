<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * WorkerMedicalSpecialities Controller
 *
 * @property \App\Model\Table\WorkerMedicalSpecialitiesTable $WorkerMedicalSpecialities
 * @method \App\Model\Entity\WorkerMedicalSpeciality[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WorkerMedicalSpecialitiesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $workerMedicalSpecialities = $this->paginate($this->WorkerMedicalSpecialities);

        $this->set(compact('workerMedicalSpecialities'));
    }

    /**
     * View method
     *
     * @param string|null $id Worker Medical Speciality id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $workerMedicalSpeciality = $this->WorkerMedicalSpecialities->get($id, [
            'contain' => ['Workers'],
        ]);

        $this->set(compact('workerMedicalSpeciality'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $workerMedicalSpeciality = $this->WorkerMedicalSpecialities->newEmptyEntity();
        if ($this->request->is('post')) {
            $workerMedicalSpeciality = $this->WorkerMedicalSpecialities->patchEntity($workerMedicalSpeciality, $this->request->getData());
            if ($this->WorkerMedicalSpecialities->save($workerMedicalSpeciality)) {
                $this->Flash->success(__('The worker medical speciality has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The worker medical speciality could not be saved. Please, try again.'));
        }
        $this->set(compact('workerMedicalSpeciality'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Worker Medical Speciality id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $workerMedicalSpeciality = $this->WorkerMedicalSpecialities->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $workerMedicalSpeciality = $this->WorkerMedicalSpecialities->patchEntity($workerMedicalSpeciality, $this->request->getData());
            if ($this->WorkerMedicalSpecialities->save($workerMedicalSpeciality)) {
                $this->Flash->success(__('The worker medical speciality has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The worker medical speciality could not be saved. Please, try again.'));
        }
        $this->set(compact('workerMedicalSpeciality'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Worker Medical Speciality id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $workerMedicalSpeciality = $this->WorkerMedicalSpecialities->get($id);
        if ($this->WorkerMedicalSpecialities->delete($workerMedicalSpeciality)) {
            $this->Flash->success(__('The worker medical speciality has been deleted.'));
        } else {
            $this->Flash->error(__('The worker medical speciality could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getList()
    {
        $this->getRequest()->allowMethod("GET");
        $worker_medical_specialities = $this->WorkerMedicalSpecialities->find('all');

        $this->set(compact('worker_medical_specialities'));
        $this->viewBuilder()->setOption('serialize', true);
    }
}
