<?php
namespace Localization\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

// ORM
use Cake\ORM\TableRegistry;

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
    public $stateName = 'estado_id';

    public $cityLabel = 'Cidade *';
    public $citiesName = 'cidade_id';

    private $stateId = null;
    private $cityId = null;

    private function injectScripts()
    {
        $scripts = $this->_View->get('js');

        if (!$scripts)
            $scripts = [];

        $scripts = array_merge($scripts, ['Localization.cities']);

        // Inject cities JS
        $this->_View->set('js', $scripts);
    }

    private function searchStates()
    {
    	$statesTable = TableRegistry::get("Estados");

    	// Search for all states
        $states = $statesTable
            ->find('all')
            ->select(['id', 'name', 'uf'])
            ->map(function ($item) {
                return [
                    'text' => $item->name,
                    'value' => $item->uf,
                    'data-uf' => $item->uf
                ];
            });

		return $states;
    }

    private function searchCities()
    {
    	$citiesTable = TableRegistry::get("Cidades");

        // Get city id
        $city = $citiesTable->get($this->cityId);

        // Set state caught id
        $this->stateId = $city->states_id;

    	// Search for all states
    	$cities = $citiesTable->find('list', [
    		'keyField' => 'id',
    		'valueField' => 'name'
		])->where(['states_id' => $city->states_id]);

		return $cities;
    }

    public function generateBasicLocation($columnSize = 'col-md-12', $citiesId = null, $cityId = 'cities', $disabled = false)
    {
        $this->injectScripts();

        // Search all states
    	$states = $this->searchStates();

        if (!empty($citiesId))
            $this->cityId = $citiesId;

        // Search for the cities
        $cities = (!empty($citiesId)) ? $this->searchCities() : [];

        $stateName = $this->stateName;
        $cityName = $this->citiesName;

    	  echo $this->Form->control($stateName, [
            'options' => $states,
            'class' => 'form-control',
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
            'class' => 'form-control',
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
