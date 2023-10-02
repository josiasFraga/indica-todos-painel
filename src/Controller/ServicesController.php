<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class ServicesController extends AppController
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

    public function index()
    {

        if ($this->request->is('post')) {
            // Get the search term from the form data
            $searchTerm = $this->request->getData('table_search');
    
            // Perform the search query based on the search term
            $query = $this->Services
                ->find()
                ->contain(['ServiceCategories', 'ServiceSubcategories', 'ServiceProviders'])
                ->where([
                    'OR' => [
                        'Services.title LIKE' => '%' . $searchTerm . '%',
                        'ServiceCategories.name LIKE' => '%' . $searchTerm . '%',
                        'ServiceSubcategories.name LIKE' => '%' . $searchTerm . '%',
                        'ServiceProviders.name LIKE' => '%' . $searchTerm . '%',
                    ]
                ]);
    
            $this->paginate = [
                'limit' => 20, // Set your desired limit per page
            ];
    
            // Paginate the query before fetching the results
            $services = $this->paginate($query);
    
            // Pass the search results to the view
            $this->set(compact('services', 'searchTerm'));
        } else {
            // If the form has not been submitted, fetch all the service subcategories as usual
            $this->paginate = [
                'contain' => ['ServiceCategories', 'ServiceSubcategories', 'ServiceProviders'],
            ];
            $services = $this->paginate($this->Services);
            $this->set(compact('services'));
        }
        

    }

    /**
     * View method
     *
     * @param string|null $id Service id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $service = $this->Services->get($id, [
            'contain' => ['ServiceCategories', 'ServiceSubcategories', 'ServiceProviders', 'Reviews'],
        ]);

        $this->set(compact('service'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $service = $this->Services->newEmptyEntity();
        if ($this->request->is('post')) {
            $service = $this->Services->patchEntity($service, $this->request->getData());
            if ($this->Services->save($service)) {
                $this->Flash->success(__('The {0} has been saved.', 'Service'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Service'));
        }
        $serviceCategories = $this->Services->ServiceCategories->find('list', ['limit' => 200]);
        $serviceSubcategories = $this->Services->ServiceSubcategories->find('list', ['limit' => 200]);
        $serviceProviders = $this->Services->ServiceProviders->find('list', ['limit' => 200]);
        $this->set(compact('service', 'serviceCategories', 'serviceSubcategories', 'serviceProviders'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Service id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $service = $this->Services->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $service = $this->Services->patchEntity($service, $this->request->getData());
            if ($this->Services->save($service)) {
                $this->Flash->success(__('The {0} has been saved.', 'Service'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Service'));
        }
        $serviceCategories = $this->Services->ServiceCategories->find('list', ['limit' => 200]);
        $serviceSubcategories = $this->Services->ServiceSubcategories->find('list', ['limit' => 200]);
        $serviceProviders = $this->Services->ServiceProviders->find('list', ['limit' => 200]);
        $this->set(compact('service', 'serviceCategories', 'serviceSubcategories', 'serviceProviders'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Service id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $service = $this->Services->get($id);
        if ($this->Services->delete($service)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Service'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Service'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
