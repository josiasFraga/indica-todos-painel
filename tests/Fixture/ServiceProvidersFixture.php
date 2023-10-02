<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ServiceProvidersFixture
 */
class ServiceProvidersFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'phone' => 'Lorem ipsum dolor sit amet',
                'address' => 'Lorem ipsum dolor sit amet',
                'address_number' => 1,
                'address_complement' => 'Lorem ipsum dolor sit amet',
                'city' => 'Lorem ipsum dolor sit amet',
                'state' => '',
                'postal_code' => 'Lorem i',
                'neighborhood' => 'Lorem ipsum dolor sit amet',
                'created' => '2023-09-29 13:07:16',
                'modified' => '2023-09-29 13:07:16',
                'active_signature' => 'Lorem ipsum dolor sit amet',
                'signature_status' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
