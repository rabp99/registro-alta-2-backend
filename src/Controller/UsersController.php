<?php

declare(strict_types=1);

namespace App\Controller;

use Firebase\JWT\JWT;
use Cake\ORM\Query;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['login']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->getRequest()->allowMethod("GET");
        $username = $this->request->getQuery('username');
        $itemsPerPage = $this->request->getQuery('itemsPerPage');

        $query = $this->Users->find()
            ->order(['Users.id']);

        if ($username) {
            $query->where(['Users.username LIKE' => "%$username%"]);
        }

        $count = $query->count();
        if (!$itemsPerPage) {
            $itemsPerPage = $count;
        }
        $users = $this->paginate($query, [
            'limit' => $itemsPerPage
        ]);
        $paginate = $this->request->getAttribute('paging')['Users'];
        $pagination = [
            'totalItems' => $paginate['count'],
            'itemsPerPage' =>  $paginate['perPage']
        ];

        $this->set(compact('users', 'pagination', 'count'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id);

        $this->set(compact('user'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->getRequest()->allowMethod('POST');
        $user = $this->Users->newEntity($this->request->getData());
        $user->status = true;
        $errors = null;

        $userTrackable = $this->getRequest()->getAttribute('identity');

        if ($this->Users->save($user, ['userId' => $userTrackable->getIdentifier()])) {
            $message = 'El usuario fue creado correctamente';
        } else {
            $message = 'El usuario no fue creado correctamente';
            $errors = $user->getErrors();
            $this->setResponse($this->response->withStatus(500));
        }

        $this->set(compact('user', 'errors', 'message'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {}

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {}

    public function login()
    {
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $privateKey = file_get_contents(CONFIG . '/jwt.key');
            $user_id = $result->getData()["id"];
            $user = $this->Users->get($user_id);

            $payload = [
                'iss' => 'sistema-epps',
                'sub' => $user->id,
                'exp' => time() + 604800,
            ];
            $json = [
                'token' => JWT::encode($payload, $privateKey, 'RS256'),
                'user' => $user
            ];
        } else {
            $this->response = $this->response->withStatus(401);
            $json = [];
        }
        $this->set(compact('json'));
        $this->viewBuilder()->setOption('serialize', 'json');
    }

    public function changePassword()
    {
        $result = $this->Authentication->getResult();
        $user_id = $result->getData()["id"];

        $newpassword = $this->request->getData('newpassword');

        $user = $this->Users->get($user_id);

        $user->password = $newpassword;

        if ($this->Users->save($user)) {
            $message = 'La contraseña fue modificada correctamente';
        } else {
            $message = 'La contraseña no fue modificada correctamente';
            $this->setResponse($this->response->withStatus(500));
        }

        $this->set(compact('message'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    public function changePasswordAdmin()
    {
        $this->request->allowMethod('POST');
        $user_id = $this->request->getData('user_id');
        $newpassword = $this->request->getData('newpassword');

        $user = $this->Users->get($user_id);

        $user->password = $newpassword;

        if ($this->Users->save($user)) {
            $message = 'La contraseña fue modificada correctamente';
        } else {
            $message = 'La contraseña no fue modificada correctamente';
            $this->setResponse($this->response->withStatus(500));
        }

        $this->set(compact('message'));
        $this->viewBuilder()->setOption('serialize', true);
    }
}
