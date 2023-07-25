<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ServiceSubcategoriesFixture
 */
class ServiceSubcategoriesFixture extends TestFixture
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
                'category_id' => 1,
                'created' => '2023-07-24 21:05:54',
                'modified' => '2023-07-24 21:05:54',
            ],
        ];
        parent::init();
    }
}
