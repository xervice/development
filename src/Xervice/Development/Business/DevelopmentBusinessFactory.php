<?php


namespace Xervice\Development\Business;


use Xervice\Core\Business\Model\Factory\AbstractBusinessFactory;
use Xervice\Development\Business\Model\Finder\ServiceFinder;
use Xervice\Development\Business\Model\Finder\ServiceFinderInterface;
use Xervice\Development\Business\Model\Generator\AutoCompleteGenerator;
use Xervice\Development\Business\Model\Generator\AutoCompleteGeneratorInterface;

/**
 * @method \Xervice\Development\DevelopmentConfig getConfig()
 */
class DevelopmentBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Xervice\Development\Business\Model\Generator\AutoCompleteGenerator
     */
    public function createGenerator(): AutoCompleteGeneratorInterface
    {
        return new AutoCompleteGenerator(
            $this->createServiceFinder(),
            $this->getConfig()->getGeneratedPath(),
            $this->getConfig()->getApplicationPath()
        );
    }

    /**
     * @return \Xervice\Development\Business\Model\Finder\ServiceFinder
     */
    public function createServiceFinder(): ServiceFinderInterface
    {
        return new ServiceFinder(
            $this->getConfig()->getDirectories()
        );
    }
}