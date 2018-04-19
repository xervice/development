<?php

namespace Xervice\Development\Finder;

interface ServiceFinderInterface
{
    /**
     * @return array
     */
    public function getServices(): array;
}