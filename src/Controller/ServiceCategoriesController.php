<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * ServiceCategories Controller
 *
 * @property \App\Model\Table\ServiceCategoriesTable $ServiceCategories
 * @method \App\Model\Entity\ServiceCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ServiceCategoriesController extends AppController
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
        $this->set('title', 'Categorias de Serviços');

        if ($this->request->is('post')) {
            // Get the search term from the form data
            $searchTerm = $this->request->getData('table_search');
    
            // Perform the search query based on the search term
            $query = $this->ServiceCategories
                ->find()
                ->where(['ServiceCategories.name LIKE' => '%' . $searchTerm . '%']);
    
            $this->paginate = [
                'limit' => 20, // Set your desired limit per page
            ];
    
            // Paginate the query before fetching the results
            $serviceCategories = $this->paginate($query);
    
            // Pass the search results to the view
            $this->set(compact('serviceCategories', 'searchTerm'));
        } else {
            // If the form has not been submitted, fetch all the service subcategories as usual
            $this->paginate = [
                // Pagination settings here
            ];
            $serviceCategories = $this->paginate($this->ServiceCategories);
            $this->set(compact('serviceCategories'));
        }
    }

    public function view($id = null)
    {
        $serviceCategory = $this->ServiceCategories->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('serviceCategory'));
    }

    public function add()
    {
        $serviceCategory = $this->ServiceCategories->newEmptyEntity();
        if ($this->request->is('post')) {
            $serviceCategory = $this->ServiceCategories->patchEntity($serviceCategory, $this->request->getData());
            if ($this->ServiceCategories->save($serviceCategory)) {
                $this->Flash->success(__('The {0} has been saved.', 'Service Category'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Service Category'));
        }
        $this->set(compact('serviceCategory'));
    }


    public function edit($id = null)
    {
        $serviceCategory = $this->ServiceCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $serviceCategory = $this->ServiceCategories->patchEntity($serviceCategory, $this->request->getData());
            if ($this->ServiceCategories->save($serviceCategory)) {
                $this->Flash->success(__('The {0} has been saved.', 'Service Category'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Service Category'));
        }
        $this->set(compact('serviceCategory'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $serviceCategory = $this->ServiceCategories->get($id);
        if ($this->ServiceCategories->delete($serviceCategory)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Service Category'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Service Category'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
