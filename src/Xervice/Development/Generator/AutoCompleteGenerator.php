<?php


namespace Xervice\Development\Generator;


use Nette\PhpGenerator\PhpNamespace;
use Xervice\Core\Client\EmptyClient;
use Xervice\Core\Config\EmptyConfig;
use Xervice\Core\Facade\EmptyFacade;
use Xervice\Core\Factory\EmptyFactory;
use Xervice\Core\Locator\Proxy\XerviceLocatorProxy;
use Xervice\Development\Finder\ServiceFinderInterface;

class AutoCompleteGenerator implements AutoCompleteGeneratorInterface
{
    const NAMESPACE = 'Generated\\Ide';

    /**
     * @var ServiceFinderInterface
     */
    private $serviceFinder;

    /**
     * @var string
     */
    private $generatedDirectory;

    /**
     * @var string
     */
    private $applicationPath;

    /**
     * AutoCompleteGenerator constructor.
     *
     * @param ServiceFinderInterface $serviceFinder
     * @param string $generatedDirectory
     * @param string $applicationPath
     */
    public function __construct(
        ServiceFinderInterface $serviceFinder,
        string $generatedDirectory,
        string $applicationPath
    ) {
        $this->serviceFinder = $serviceFinder;
        $this->generatedDirectory = $generatedDirectory;
        $this->applicationPath = $applicationPath;
    }


    public function generate()
    {
        $namespace = new PhpNamespace(self::NAMESPACE);

        $locatorAutoComplete = $namespace->addInterface('LocatorAutoComplete');
        foreach ($this->serviceFinder->getServices() as $service => $path) {
            $serviceNamespace = $this->getServiceNamespace($path);

            $serviceClass = $namespace->addClass($service);
            $serviceClass->setAbstract(true);
            $serviceClass->addComment(
                '@method ' . $serviceNamespace . '\\' . $service . 'Client|\\' . EmptyClient::class . ' client()'
            );
            $serviceClass->addComment(
                '@method ' . $serviceNamespace . '\\' . $service . 'Config|\\' . EmptyConfig::class . ' config()'
            );
            $serviceClass->addComment(
                '@method ' . $serviceNamespace . '\\' . $service . 'Facade|\\' . EmptyFacade::class . ' facade()'
            );
            $serviceClass->addComment(
                '@method ' . $serviceNamespace . '\\' . $service . 'Factory|\\' . EmptyFactory::class . ' factory()'
            );

            $locatorAutoComplete->addComment('@method \\' . self::NAMESPACE . '\\' . $service . ' ' . lcfirst($service));
        }

        file_put_contents(
            $this->generatedDirectory . '/LocatorAutoComplete.php', '<?php' . PHP_EOL . (string)$namespace
        );
    }

    /**
     * @param $path
     */
    private function getServiceNamespace($path)
    {
        $namespace = $path->getFilename();
        if (strpos($path->getRealPath(), '/vendor/') !== false) {
            $namespace = '\\Xervice\\' . $namespace;
        }
        else {
            $namespacePrefix = str_replace(
                $this->applicationPath . '/src/',
                '',
                $path->getPath()
            );
            $namespace = '\\' . $namespacePrefix . '\\' . $namespace;
        }

        return $namespace;
    }
}