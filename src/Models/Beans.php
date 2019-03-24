<?php

namespace SoConnect\Coffee\Models;

use SoConnect\Coffee\Exceptions\ContainerFullException;
use SoConnect\Coffee\Interfaces\BeansContainer;

/**
 * Class Beans
 * @package SoConnect\Coffee\Models
 */
class Beans extends AbstractContainer implements BeansContainer
{

    /**
     * @param int $numSpoons
     * @throws ContainerFullException
     */
    public function addBeans(int $numSpoons) : void
    {
        $this->add($numSpoons);
    }

    /**
     * @param int $numSpoons
     * @return int
     */
    public function useBeans(int $numSpoons) : int
    {
        return $this->use($numSpoons);
    }

    /**
     * @return int
     */
    public function getBeans() : int
    {
        return $this->get();
    }
}