<?php
declare(strict_types=1);

namespace App\Controller;
use Authentication\PasswordHasher\DefaultPasswordHasher;

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
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->allowUnauthenticated(['login', 'logout', 'hashPassword']);
    }
    /**
     * Login method
     *
     * @return \Cake\Http\Response|null Redirects on successful login, renders view otherwise.
     */
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

    /**
     * Logout method
     *
     * @return \Cake\Http\Response|null Redirects to login.
     */
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
