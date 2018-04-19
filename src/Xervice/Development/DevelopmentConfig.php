<?php


namespace Xervice\Development;


use Xervice\Config\XerviceConfig;
use Xervice\Core\Config\AbstractConfig;
use Xervice\Core\CoreConfig;
use Xervice\Core\Locator\Locator;

class DevelopmentConfig extends AbstractConfig
{
    const GENERATED_PATH = 'generated.path';

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
        $dirs = [
            $this->get(XerviceConfig::APPLICATION_PATH) . '/src/Xervice/',
            $this->get(XerviceConfig::APPLICATION_PATH) . '/src/' . $this->get(CoreConfig::PROJECT_LAYER_NAMESPACE) . '/',
            $this->get(XerviceConfig::APPLICATION_PATH) . '/vendor/Xervice/*/src/Xervice/'
        ];

        foreach ($dirs as $key => $dir) {
            if (!is_dir($dir)) {
                unset($dirs[$key]);
            }
        }

        return $dirs;
    }
}