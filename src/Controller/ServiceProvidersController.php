<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class ServiceProvidersController extends AppController
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
        //$this->Authentication->addUnauthenticatedActions(['login']); // Ação de login não requer autenticação
        $this->Authorization->skipAuthorization();

        if (!$this->Authentication->getIdentity()) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        return true;
    }

    public function isAuthorized($user)
    {
        // Permitir acesso a todas as ações para usuários logados
        return $this->Authentication->getIdentity() !== null;
    }

    public function index()
    {

        if ($this->request->is('post')) {
            // Get the search term from the form data
            $searchTerm = $this->request->getData('table_search');
    
            // Perform the search query based on the search term
            $query = $this->ServiceProviders
                ->find()
                //->contain(['ServiceCategories'])
                ->where([
                    /*'OR' => [
                        'ServiceProviders.name LIKE' => '%' . $searchTerm . '%',
                        'ServiceCategories.name LIKE' => '%' . $searchTerm . '%',
                    ]*/
                    'ServiceProviders.name LIKE' => '%' . $searchTerm . '%',
                ]);
    
            $this->paginate = [
                'limit' => 20, // Set your desired limit per page
            ];
    
            // Paginate the query before fetching the results
            $serviceProviders = $this->paginate($query);
    
            // Pass the search results to the view
            $this->set(compact('serviceProviders', 'searchTerm'));
        } else {
            // If the form has not been submitted, fetch all the service subcategories as usual
            $this->paginate = [
                //'contain' => ['ServiceCategories'],
            ];
            $serviceProviders = $this->paginate($this->ServiceProviders);
            $this->set(compact('serviceProviders'));
        }

    }


    public function view($id = null)
    {
        $serviceProvider = $this->ServiceProviders->get($id, [
            'contain' => [
                'Services' => [
                    'ServiceCategories',
                    'ServiceSubcategories'
                ], 
                'Users'
            ],
        ]);

        $this->set(compact('serviceProvider'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $serviceProvider = $this->ServiceProviders->newEmptyEntity();
        if ($this->request->is('post')) {
            $serviceProvider = $this->ServiceProviders->patchEntity($serviceProvider, $this->request->getData());
            if ($this->ServiceProviders->save($serviceProvider)) {
                $this->Flash->success(__('The {0} has been saved.', 'Service Provider'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Service Provider'));
        }
        $this->set(compact('serviceProvider'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Service Provider id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $serviceProvider = $this->ServiceProviders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $serviceProvider = $this->ServiceProviders->patchEntity($serviceProvider, $this->request->getData());
            if ($this->ServiceProviders->save($serviceProvider)) {
                $this->Flash->success(__('The {0} has been saved.', 'Service Provider'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Service Provider'));
        }
        $this->set(compact('serviceProvider'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Service Provider id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $serviceProvider = $this->ServiceProviders->get($id);
        if ($this->ServiceProviders->delete($serviceProvider)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Service Provider'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Service Provider'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
