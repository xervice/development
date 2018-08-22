<?php

namespace Xervice\Development\Business\Model\Finder;

interface ServiceFinderInterface
{
    /**
     * @return array
     */
    public function getServices(): array;
}