<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
/**
 * ServiceSubcategories Controller
 *
 * @property \App\Model\Table\ServiceSubcategoriesTable $ServiceSubcategories
 * @method \App\Model\Entity\ServiceSubcategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ServiceSubcategoriesController extends AppController
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
            $query = $this->ServiceSubcategories
                ->find()
                ->contain(['ServiceCategories'])
                ->where([
                    'OR' => [
                        'ServiceSubcategories.name LIKE' => '%' . $searchTerm . '%',
                        'ServiceCategories.name LIKE' => '%' . $searchTerm . '%',
                    ]
                ]);
    
            $this->paginate = [
                'limit' => 20, // Set your desired limit per page
            ];
    
            // Paginate the query before fetching the results
            $serviceSubcategories = $this->paginate($query);
    
            // Pass the search results to the view
            $this->set(compact('serviceSubcategories', 'searchTerm'));
        } else {
            // If the form has not been submitted, fetch all the service subcategories as usual
            $this->paginate = [
                'contain' => ['ServiceCategories'],
            ];
            $serviceSubcategories = $this->paginate($this->ServiceSubcategories);
            $this->set(compact('serviceSubcategories'));
        }
    
 
    }


    public function view($id = null)
    {
        $serviceSubcategory = $this->ServiceSubcategories->get($id, [
            'contain' => ['ServiceCategories'],
        ]);

        $this->set(compact('serviceSubcategory'));
    }

    public function add()
    {
        $serviceSubcategory = $this->ServiceSubcategories->newEmptyEntity();
        if ($this->request->is('post')) {
            $serviceSubcategory = $this->ServiceSubcategories->patchEntity($serviceSubcategory, $this->request->getData());
            if ($this->ServiceSubcategories->save($serviceSubcategory)) {
                $this->Flash->success(__('The {0} has been saved.', 'Service Subcategory'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Service Subcategory'));
        }
        $serviceCategories = $this->ServiceSubcategories->ServiceCategories->find('list', ['limit' => 200]);
        $this->set(compact('serviceSubcategory', 'serviceCategories'));
    }

    public function edit($id = null)
    {
        $serviceSubcategory = $this->ServiceSubcategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $serviceSubcategory = $this->ServiceSubcategories->patchEntity($serviceSubcategory, $this->request->getData());
            if ($this->ServiceSubcategories->save($serviceSubcategory)) {
                $this->Flash->success(__('The {0} has been saved.', 'Service Subcategory'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Service Subcategory'));
        }
        $serviceCategories = $this->ServiceSubcategories->ServiceCategories->find('list', ['limit' => 200]);
        $this->set(compact('serviceSubcategory', 'serviceCategories'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $serviceSubcategory = $this->ServiceSubcategories->get($id);
        if ($this->ServiceSubcategories->delete($serviceSubcategory)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Service Subcategory'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Service Subcategory'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
