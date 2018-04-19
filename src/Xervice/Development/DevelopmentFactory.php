<?php


namespace Xervice\Development;


use Xervice\Core\Factory\AbstractFactory;
use Xervice\Core\Locator\Locator;
use Xervice\Development\Finder\ServiceFinder;
use Xervice\Development\Finder\ServiceFinderInterface;
use Xervice\Development\Generator\AutoCompleteGenerator;
use Xervice\Development\Generator\AutoCompleteGeneratorInterface;

/**
 * @method \Xervice\Development\DevelopmentConfig getConfig()
 */
class DevelopmentFactory extends AbstractFactory
{
    /**
     * @return \Xervice\Development\Generator\AutoCompleteGeneratorInterface
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function createGenerator(): AutoCompleteGeneratorInterface
    {
        return new AutoCompleteGenerator(
            $this->createServiceFinder(),
            $this->getConfig()->getGeneratedPath()
        );
    }

    /**
     * @return \Xervice\Development\Finder\ServiceFinderInterface
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function createServiceFinder(): ServiceFinderInterface
    {
        return new ServiceFinder(
            $this->getConfig()->getDirectories()
        );
    }
}