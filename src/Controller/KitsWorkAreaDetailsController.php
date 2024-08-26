<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * KitsWorkAreaDetails Controller
 *
 * @method \App\Model\Entity\KitsWorkAreaDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KitsWorkAreaDetailsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['getKitsByWorkAreaDetail']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $kitsWorkAreaDetails = $this->paginate($this->KitsWorkAreaDetails);

        $this->set(compact('kitsWorkAreaDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Kits Work Area Detail id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $kitsWorkAreaDetail = $this->KitsWorkAreaDetails->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('kitsWorkAreaDetail'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $kitsWorkAreaDetail = $this->KitsWorkAreaDetails->newEmptyEntity();
        if ($this->request->is('post')) {
            $kitsWorkAreaDetail = $this->KitsWorkAreaDetails->patchEntity($kitsWorkAreaDetail, $this->request->getData());
            if ($this->KitsWorkAreaDetails->save($kitsWorkAreaDetail)) {
                $this->Flash->success(__('The kits work area detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kits work area detail could not be saved. Please, try again.'));
        }
        $this->set(compact('kitsWorkAreaDetail'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Kits Work Area Detail id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $kitsWorkAreaDetail = $this->KitsWorkAreaDetails->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $kitsWorkAreaDetail = $this->KitsWorkAreaDetails->patchEntity($kitsWorkAreaDetail, $this->request->getData());
            if ($this->KitsWorkAreaDetails->save($kitsWorkAreaDetail)) {
                $this->Flash->success(__('The kits work area detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kits work area detail could not be saved. Please, try again.'));
        }
        $this->set(compact('kitsWorkAreaDetail'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Kits Work Area Detail id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $kitsWorkAreaDetail = $this->KitsWorkAreaDetails->get($id);
        if ($this->KitsWorkAreaDetails->delete($kitsWorkAreaDetail)) {
            $this->Flash->success(__('The kits work area detail has been deleted.'));
        } else {
            $this->Flash->error(__('The kits work area detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getKitsByWorkAreaDetail()
    {
        $this->getRequest()->allowMethod("GET");
        $this->viewBuilder()->setOption('serialize', true);

        $workAreaDetailId = $this->getRequest()->getParam("work_area_detail_id");

        $kits = $this->KitsWorkAreaDetails->Kits->find()
            ->matching('WorkAreaDetails', function ($q) use ($workAreaDetailId) {
                return $q->where(['WorkAreaDetails.id' => $workAreaDetailId]);
            })
            ->contain(['Products'])
            ->map(function ($kit) {
                $kit->amount = $kit->_matchingData["KitsWorkAreaDetails"]->amount;
                unset($kit->_matchingData);
                foreach ($kit->products as $product) {
                    $product->amount = $product->_joinData->amount;
                    unset($product->_joinData);
                }
                return $kit;
            });

        $this->set(compact('kits'));
    }
}
