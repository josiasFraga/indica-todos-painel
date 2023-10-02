<?php
namespace Localization\Controller;
use Localization\Controller\AppController;
use Cake\Http\Client;  // Import the HTTP Client
use Cake\Event\EventInterface;


class CidadesController extends AppController
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
        $this->Authentication->allowUnauthenticated(['index']);
    }


    public function index($_stateId = null)
    {
        $this->viewBuilder()->setLayout('Localization.ajax');       

        $client = new Client();
        $response = $client->get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$_stateId}/municipios");

        if (!$response->isOk()) {
            $this->response = $this->response->withType('application/json')->withStringBody(json_encode(['error' => 'Failed to fetch data']));
            return $this->response;
        }

        $citiesData = $response->getJson();
        $cidades = [];
        foreach ($citiesData as $city) {
            
            $cidades[$city['nome']] = $city['nome'];
            /*$cidades[] = [
                'id' => $city['nome'],
                'name' => $city['nome']
            ];*/
        };
    
        $this->response = $this->response->withType('application/json')->withStringBody(json_encode(['cidades' => $cidades]));
        return $this->response;
    }

    /**
     * View method
     *
     * @param string|null $id City id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->layout('Localization.ajax');

        $cidade = $this->Cidades->get($id);

        $this->set('cidade', $cidade);
        $this->set('_serialize', ['cidade']);
    }
}
