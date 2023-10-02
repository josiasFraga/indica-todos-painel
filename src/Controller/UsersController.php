<?php
declare(strict_types=1);

namespace App\Controller;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Event\EventInterface;

class UsersController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authorization.Authorization');
        //$this->Authorization->authorize(new PromocaoPolicy());
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
    
        // Permitir que apenas usuários não autenticados acessem as actions 'login', 'logout', e 'hashPassword'
        $this->Authentication->allowUnauthenticated(['login', 'logout', 'hashPassword']);
    
        // Se o usuário não estiver autenticado, redirecione para a página de login
        if (!$this->Authentication->getIdentity() && !in_array($this->request->getParam('action'), ['login', 'logout', 'hashPassword'])) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    
        $this->Authorization->skipAuthorization();
        
    }
    
    public function index()
    {
        

        if ($this->request->is('post')) {
            // Get the search term from the form data
            $searchTerm = $this->request->getData('table_search');
    
            // Perform the search query based on the search term
            $query = $this->Users
                ->find()
                ->contain(['ServiceProviders'])
                ->where([
                    'OR' => [
                        'Users.name LIKE' => '%' . $searchTerm . '%',
                        'Users.email LIKE' => '%' . $searchTerm . '%',
                        'Users.phone LIKE' => '%' . $searchTerm . '%',
                        'Users.cpf LIKE' => '%' . $searchTerm . '%',
                        'ServiceProviders.name LIKE' => '%' . $searchTerm . '%',
                    ],
                    'not' => [
                        'Users.email' => 'admin@indicatodos.com.br'
                    ]
                ]);
    
            $this->paginate = [
                'limit' => 20, // Set your desired limit per page
            ];
    
            // Paginate the query before fetching the results
            $users = $this->paginate($query);
    
            // Pass the search results to the view
            $this->set(compact('users', 'searchTerm'));
        } else {
            
    
            // Perform the search query based on the search term
            $query = $this->Users
                ->find()
                ->contain(['ServiceProviders'])
                ->where([
                    'not' => [
                        'Users.email' => 'admin@indicatodos.com.br'
                    ]
                ]);

            // If the form has not been submitted, fetch all the service subcategories as usual
            $this->paginate = [
                'limit' => 20, // Set your desired limit per page
            ];
            $users = $this->paginate($query);
            $this->set(compact('users'));
        }


    }

    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['ServiceProviders'],
        ]);

        $this->set(compact('user'));
    }


    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The {0} has been saved.', 'User'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'User'));
        }
        $serviceProviders = $this->Users->ServiceProviders->find('list', ['limit' => 200]);
        $this->set(compact('user', 'serviceProviders'));
    }


    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The {0} has been saved.', 'User'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'User'));
        }
        $serviceProviders = $this->Users->ServiceProviders->find('list', ['limit' => 200]);
        $this->set(compact('user', 'serviceProviders'));
    }


    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The {0} has been deleted.', 'User'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'User'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {

        $this->Authorization->skipAuthorization();
        if ($this->request->is('post')) {
            $result = $this->Authentication->getResult();
            // If the user is logged in send them away.
            if ($result->isValid()) {
                $target = '/';
                return $this->redirect($target);
            }
            if ($this->request->is('post')) {
                $this->Flash->error(__('Nome de usuários e/ou senha inválidos!'));
            }
        }
    }

    public function logout()
    {
        $this->Authorization->skipAuthorization();
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function hashPassword()
    {
        $this->Authorization->skipAuthorization();
        $password = "zap123";

        $hasher = new DefaultPasswordHasher();
        echo $hasher->hash($password);
    
        die();
    }
}
