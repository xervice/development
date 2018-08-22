<?php


namespace Xervice\Development\Business;


use Xervice\Core\Business\Model\Facade\AbstractFacade;


/**
 * @method \Xervice\Development\Business\DevelopmentFactory getFactory()
 * @method \Xervice\Development\DevelopmentConfig getConfig()
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