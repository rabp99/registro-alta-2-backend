<?php

declare(strict_types=1);

namespace App\Controller;

use SplFileObject;
use Cake\Utility\Security;

/**
 * Parameters Controller
 *
 * @property \App\Model\Table\ParametersTable $Parameters
 * @method \App\Model\Entity\Parameter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ParametersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $parameters = $this->paginate($this->Parameters);

        $this->set(compact('parameters'));
    }

    /**
     * View method
     *
     * @param string|null $id Parameter id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $parameter = $this->Parameters->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('parameter'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $parameter = $this->Parameters->newEmptyEntity();
        if ($this->request->is('post')) {
            $parameter = $this->Parameters->patchEntity($parameter, $this->request->getData());
            if ($this->Parameters->save($parameter)) {
                $this->Flash->success(__('The parameter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The parameter could not be saved. Please, try again.'));
        }
        $this->set(compact('parameter'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Parameter id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $parameter = $this->Parameters->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $parameter = $this->Parameters->patchEntity($parameter, $this->request->getData());
            if ($this->Parameters->save($parameter)) {
                $this->Flash->success(__('The parameter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The parameter could not be saved. Please, try again.'));
        }
        $this->set(compact('parameter'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Parameter id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $parameter = $this->Parameters->get($id);
        if ($this->Parameters->delete($parameter)) {
            $this->Flash->success(__('The parameter has been deleted.'));
        } else {
            $this->Flash->error(__('The parameter could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getByKeys()
    {
        $this->getRequest()->allowMethod("GET");
        $this->viewBuilder()->setOption('serialize', true);

        $keys = explode(",", $this->getRequest()->getParam("keys"));

        $values = collection($keys)->combine(function ($key) {
            return $key;
        }, function ($key) {
            if ($key === "responsible.signature") {
                $signaturePath = $this->Parameters->findByKey($key)->first()->get('value');
                return $this->getImageBase64(STORAGE_PATH . $signaturePath);
            } else {
                return $this->Parameters->findByKey($key)->first()->get('value');
            }
        });

        $this->set(compact('values'));
    }

    private function getImageBase64($imagePath)
    {
        try {
            $file = new SplFileObject($imagePath, 'r');

            $file->fseek(0, SEEK_END);
            $fileSize = $file->ftell();
            $file->rewind();
            $imageContent = $file->fread($fileSize);

            $mimeType = mime_content_type($imagePath);

            $base64Image = base64_encode($imageContent);

            // Devuelve la cadena base64 con el tipo MIME
            return 'data:' . $mimeType . ';base64,' . $base64Image;
        } catch (\Throwable $th) {
            return "";
        }
    }

    public function saveConfiguration()
    {
        $this->getRequest()->allowMethod("POST");
        $this->viewBuilder()->setOption('serialize', true);
        $userTrackable = $this->request->getAttribute('identity');

        $data = $this->getRequest()->getData();

        $parameter = $this->Parameters->findByKey("responsible.full_name")->first();
        $parameter->value = $data["responsibleFullName"];
        $this->Parameters->saveOrFail($parameter, ['userId' => $userTrackable->getIdentifier()]);

        $parameter = $this->Parameters->findByKey("responsible.job_position")->first();
        $parameter->value = $data["responsibleJobPosition"];
        $this->Parameters->saveOrFail($parameter, ['userId' => $userTrackable->getIdentifier()]);

        $parameter = $this->Parameters->findByKey("responsible.signature")->first();
        $base64Signature = $data["responsibleSignature"];
        $filePath = $this->saveBase64File($base64Signature);
        $parameter->value = $filePath;
        $this->Parameters->saveOrFail($parameter, ['userId' => $userTrackable->getIdentifier()]);

        $message = 'La configuración fue guardada satisfactoriamente';
        $this->set(compact('message'));
    }

    protected function saveBase64File($base64File)
    {
        $path = STORAGE_PATH . "signatures";

        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }

        $base64FileString = preg_replace('#^data:image/\w+;base64,#i', '', $base64File);

        $fileData = base64_decode($base64FileString);

        $filename = Security::hash(time() . rand()) . '.png';

        $filePath = $path . DS . $filename;
        $file = new SplFileObject($filePath, 'w');
        $file->fwrite($fileData);

        return "signatures" . DS . $filename;
    }
}
