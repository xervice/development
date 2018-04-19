<?php


namespace Xervice\Development;


use Xervice\Core\Facade\AbstractFacade;

/**
 * @method \Xervice\Development\DevelopmentFactory getFactory()
 * @method \Xervice\Development\DevelopmentConfig getConfig()
 * @method \Xervice\Development\DevelopmentClient getClient()
 */
class DevelopmentFacade extends AbstractFacade
{
    /**
     * Generate Autocomplete
     *
     * @api
     */
    public function generateAutoComplete()
    {
        $this->getFactory()->createGenerator()->generate();
    }
}