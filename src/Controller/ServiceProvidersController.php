<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Database\Exception;
use Cake\Datasource\ConnectionManager;

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


    public function add()
    {

        $this->loadModel('Services');
        $serviceProvider = $this->ServiceProviders->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Associando os dados às entidades
            $serviceProvider = $this->ServiceProviders->patchEntity($serviceProvider, $data, [
                'associated' => ['Users', 'Services']
            ]);
    
            // Usando a transação para garantir a integridade dos dados
            $connection = ConnectionManager::get('default');
            $connection->begin();
            try {
                // Verificando se os dados são válidos antes de salvar
                if ($this->ServiceProviders->save($serviceProvider, ['atomic' => false])) {
                    // Se tudo estiver OK, commit da transação
                    $connection->commit();
                    $this->Flash->success(__('Todos os dados foram salvos com sucesso.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    // Se algo der errado, faz rollback da transação
                    $connection->rollback();
                    $this->Flash->error(__('Não foi possível salvar os dados.'));
                }
            } catch (Exception $e) {
                // Em caso de exceção, faz rollback da transação
                $connection->rollback();
                $this->Flash->error($e->getMessage());
            }
        }
    
        $serviceCategories = $this->Services->ServiceCategories->find('list', ['limit' => 200]);
        $serviceSubcategories = $this->Services->ServiceSubcategories->find('list', ['limit' => 200]);

        $this->set(compact('serviceProvider', 'serviceCategories', 'serviceSubcategories'));
        

    }


    public function edit($id = null)
    {

        $this->loadModel('Services');
        $this->loadModel('ServiceSubcategories');

        $serviceProvider = $this->ServiceProviders->get($id, [
            'contain' => ['Users', 'Services']
        ]);

 
        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();

            if ( empty($data['users']['0']['password']) ) {
                unset($data['users']['0']['password']);
            }

            $serviceProvider = $this->ServiceProviders->patchEntity($serviceProvider, $data, [
                'associated' => ['Users', 'Services']
            ]);

            if ($this->ServiceProviders->save($serviceProvider, ['atomic' => false])) {
                $this->Flash->success(__('The {0} has been saved.', 'Service Provider'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Service Provider'));
        }
    
        $serviceCategories = $this->Services->ServiceCategories->find('list', ['limit' => 200]);
        $serviceSubcategories = $this->Services->ServiceSubcategories->find('list', ['limit' => 200]);

        $this->set(compact('serviceProvider', 'serviceCategories', 'serviceSubcategories'));
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
