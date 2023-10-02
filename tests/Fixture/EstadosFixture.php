<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EstadosFixture
 */
class EstadosFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'cod_uf' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'uf' => '',
                'region' => 'Lorem ipsum dolor ',
            ],
        ];
        parent::init();
    }
}
