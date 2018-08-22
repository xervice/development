<?php


namespace Xervice\Development\Business\Model\Generator;


use Nette\PhpGenerator\PhpNamespace;
use Symfony\Component\Finder\SplFileInfo;
use Xervice\Core\Business\Model\Facade\AbstractFacade;
use Xervice\Development\Business\Model\Finder\ServiceFinderInterface;

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
                '@method ' . $serviceNamespace . '\\Business\\' . $service . 'Facade|\\' . AbstractFacade::class . ' facade()'
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
    private function getServiceNamespace(SplFileInfo $path)
    {
        $namespace = $path->getFilename();
        if (strpos($path->getRealPath(), '/vendor/') !== false) {
            $vendorPath = substr($path->getRealPath(), strpos($path->getRealPath(), 'vendor') + 7);
            if (preg_match('@([A-Za-z]+)/([A-Za-z]+)/([A-Za-z]+)/([A-Za-z]+)/([A-Za-z]+)@', $vendorPath, $matches)) {
                $namespace = '\\' . $matches[4] . '\\' . $namespace;
            } else {
                $namespace = '\\Xervice\\' . $namespace;
            }
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