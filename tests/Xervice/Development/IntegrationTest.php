<?php
namespace XerviceTest\Development;

use Generated\Ide\LocatorAutoComplete;
use Xervice\Core\Locator\Dynamic\DynamicLocator;

/**
 * @method \Xervice\Development\DevelopmentFacade getFacade()
 */
class IntegrationTest extends \Codeception\Test\Unit
{
    use DynamicLocator;

    /**
     * @var \XerviceTest\XerviceTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     * @throws \Core\Locator\Dynamic\ServiceNotParseable
     */
    public function testSomeFeature()
    {
        $this->getFacade()->generateAutoComplete();
        $this->assertTrue(
            interface_exists(LocatorAutoComplete::class)
        );
    }
}