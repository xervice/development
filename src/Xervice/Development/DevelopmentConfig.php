<?php


namespace Xervice\Development;


use Xervice\Config\XerviceConfig;
use Xervice\Core\Config\AbstractConfig;
use Xervice\Core\CoreConfig;
use Xervice\Core\Locator\Locator;

class DevelopmentConfig extends AbstractConfig
{
    public const GENERATED_PATH = 'generated.path';

    public const SEARCH_PATHS = 'search.paths';

    /**
     * @return string
     * @throws \Xervice\Config\Exception\ConfigNotFound
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
     * @throws \Xervice\Config\Exception\ConfigNotFound
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
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function getApplicationPath()
    {
        return $this->get(XerviceConfig::APPLICATION_PATH);
    }

    /**
     * @return array
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    private function getDefaultSearchPaths(): array
    {
        return [
            $this->get(XerviceConfig::APPLICATION_PATH) . '/src/' . $this->get(CoreConfig::PROJECT_LAYER_NAMESPACE)
            . '/',
            $this->get(XerviceConfig::APPLICATION_PATH) . '/src/Xervice/',
            $this->get(XerviceConfig::APPLICATION_PATH) . '/vendor/xervice/*/src/Xervice/'
        ];
    }
}