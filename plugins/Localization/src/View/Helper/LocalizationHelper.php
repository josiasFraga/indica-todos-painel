<?php
namespace Localization\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\Http\Client;  // Import the HTTP Client

class LocalizationHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Load helper
     **/
    public $helpers = ['Form', 'Url'];

    public $stateLabel = 'Estado *';
    public $stateName = 'state';

    public $cityLabel = 'Cidade *';
    public $citiesName = 'city';

    private $stateId = null;
    private $cityId = null;

    private function injectScripts()
    {

        $this->_View->Html->script('Localization.cidades', ['block' => 'scriptBottom']);

    }

    private function searchStates()
    {
        $client = new Client();
        $response = $client->get('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome');
        
        if (!$response->isOk()) {
            // Handle error
            return [];
        }

        $statesData = $response->getJson();
        $states = [];
        foreach ($statesData as $state) {
            $states[] = [
                'text' => $state['nome'],
                'value' => $state['sigla'],
                'data-uf' => $state['sigla']
            ];
        }

        return $states;
    }

    private function searchCities($_stateId)
    {

        $client = new Client();
        $response = $client->get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$_stateId}/municipios");

        if (!$response->isOk()) {
            // Handle error
            return [];
        }

        $citiesData = $response->getJson();
        $cities = [];
        foreach ($citiesData as $city) {
            $cities[$city['nome']] = $city['nome'];
        }

        return $cities;
    }

    public function generateBasicLocation($columnSize = 'col-md-12', $citiesId = null, $cityId = 'cities', $disabled = false, $extra_classes = '', $_stateId = null)
    {
        $this->injectScripts();

        // Search all states
        $states = $this->searchStates();

        if (!empty($citiesId))
            $this->cityId = $citiesId;

        // Search for the cities
        $cities = (!empty($citiesId)) ? $this->searchCities($_stateId) : [];

        $stateName = $this->stateName;
        $cityName = $this->citiesName;

        echo $this->Form->control($stateName, [
            'options' => $states,
            'class' => 'form-control '.$extra_classes,
            'id' => 'states',
            'city-result' => '#' . $cityId,
            'templateVars' => ['col' => $columnSize],
            'empty' => ['' => 'Selecione um estado'],
            'required' => false,
            'error' => false,
            'label' => $this->stateLabel,
            'value' => $this->stateId,
            'disabled' => $disabled
        ]);

        echo $this->Form->control($cityName, [
            'options' => $cities,
            'class' => 'form-control '.$extra_classes,
            'id' => $cityId,
            'templateVars' => ['col' => $columnSize],
            'empty' => ['' => 'Selecione uma cidade'],
            'required' => false,
            'error' => false,
            'label' => $this->cityLabel,
            'value' => $this->cityId,
            'disabled' => $disabled
        ]);

        echo $this->Form->control('cities_url', [
            'type' => 'hidden',
            'id' => 'cities-url',
            'label' => false,
            'value' => $this->Url->build([
                'plugin' => 'Localization',
                'controller' => 'Cidades',
                'action' => 'index'
            ], ['_full' => true])
        ]);
    }
}
