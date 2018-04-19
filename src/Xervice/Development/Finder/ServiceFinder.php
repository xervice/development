<?php


namespace Xervice\Development\Finder;


use Symfony\Component\Finder\Finder;

class ServiceFinder implements ServiceFinderInterface
{
    /**
     * @var array
     */
    private $directories;

    /**
     * ServiceFinder constructor.
     *
     * @param array $directories
     */
    public function __construct(array $directories)
    {
        $this->directories = $directories;
    }

    /**
     * @return array
     */
    public function getServices(): array
    {
        $services = [];

        $finder = new Finder();
        $finder->directories()->in($this->directories);

        foreach ($finder as $dir) {
            if (!in_array($dir->getFilename(), $services)) {
                $services[] = $dir->getFilename();
            }
        }

        return $services;
    }
}