<?php
namespace Localization\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Localization\View\Helper\LocalizationHelper;

/**
 * Localization\View\Helper\LocalizationHelper Test Case
 */
class LocalizationHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Localization\View\Helper\LocalizationHelper
     */
    public $Localization;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Localization = new LocalizationHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Localization);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
