<?php


namespace Xervice\Development\Generator;


use Nette\PhpGenerator\PhpNamespace;
use Xervice\Core\Locator\Proxy\XerviceLocatorProxy;
use Xervice\Development\Finder\ServiceFinderInterface;

class AutoCompleteGenerator implements AutoCompleteGeneratorInterface
{
    const NAMESPACE = 'Generated\\Ide';

    /**
     * @var \Xervice\Development\Finder\ServiceFinderInterface
     */
    private $serviceFinder;

    /**
     * @var string
     */
    private $generatedDirectory;

    /**
     * AutoCompleteGenerator constructor.
     *
     * @param \Xervice\Development\Finder\ServiceFinderInterface $serviceFinder
     * @param string $generatedDirectory
     */
    public function __construct(
        ServiceFinderInterface $serviceFinder,
        string $generatedDirectory
    ) {
        $this->serviceFinder = $serviceFinder;
        $this->generatedDirectory = $generatedDirectory;
    }

    public function generate()
    {
        $namespace = new PhpNamespace(self::NAMESPACE);

        $locatorAutoComplete = $namespace->addInterface('LocatorAutoComplete');
        foreach ($this->serviceFinder->getServices() as $service) {
            $serviceClass = $namespace->addClass($service);
            $serviceClass->setAbstract(true);
            $serviceClass->setExtends(XerviceLocatorProxy::class);

            $serviceMethod = $locatorAutoComplete->addMethod(lcfirst($service));
            $serviceMethod->setVisibility('public');
            $serviceMethod->setReturnType(self::NAMESPACE . '\\' . $service);
        }

        file_put_contents($this->generatedDirectory . '/LocatorAutoComplete.php', '<?php' . PHP_EOL . (string)$namespace);
    }
}