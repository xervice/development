<?php
namespace XerviceTest\Development;

use Generated\Ide\LocatorAutoComplete;
use Xervice\Core\Business\Model\Locator\Dynamic\Business\DynamicBusinessLocator;

/**
 * @method \Xervice\Development\DevelopmentFacade getFacade()
 */
class IntegrationTest extends \Codeception\Test\Unit
{
    use DynamicBusinessLocator;

    public function testSomeFeature()
    {
        $this->getFacade()->generateAutoComplete();
        $this->assertTrue(
            interface_exists(LocatorAutoComplete::class)
        );
    }
}