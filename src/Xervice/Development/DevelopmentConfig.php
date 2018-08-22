<?php


namespace Xervice\Development;


use Xervice\Config\Business\XerviceConfig;
use Xervice\Core\Business\Model\Config\AbstractConfig;
use Xervice\Core\CoreConfig;

class DevelopmentConfig extends AbstractConfig
{
    public const GENERATED_PATH = 'generated.path';

    public const SEARCH_PATHS = 'search.paths';

    /**
     * @return string
     */
    public function getGeneratedPath()
    {
        return $this->get(
            self::GENERATED_PATH,
            $this->get(XerviceConfig::APPLICATION_PATH) . '/src/Generated/Ide'
        );
    }

    /**
     * @return array
     */
    public function getDirectories()
    {
        $dirs = $this->get(self::SEARCH_PATHS, $this->getDefaultSearchPaths());

        foreach ($dirs as $key => $dir) {
            if (strpos($dir, '*') === false && !is_dir($dir)) {
                unset($dirs[$key]);
            }
        }

        return $dirs;
    }

    /**
     * @return string
     */
    public function getApplicationPath()
    {
        return $this->get(XerviceConfig::APPLICATION_PATH);
    }

    /**
     * @return array
     */
    private function getDefaultSearchPaths(): array
    {
        $paths = [];
        $applicationPath = $this->get(XerviceConfig::APPLICATION_PATH);

        foreach ($this->get(CoreConfig::CORE_NAMESPACES, []) as $namespace) {
            $paths[] = $applicationPath . '/vendor/' . strtolower($namespace) . '/*/src/' . $namespace . '/';
        }

        foreach ($this->get(CoreConfig::PROJECT_NAMESPACES, []) as $namespace) {
            $paths[] = $applicationPath . '/src/' . $namespace;
        }

        return $paths;
    }
}