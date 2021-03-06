<?php

namespace SoConnect\Coffee\Models;

use SoConnect\Coffee\Exceptions\ContainerFullException;
use SoConnect\Coffee\Interfaces\WaterContainer;

/**
 * Class Water
 * @package SoConnect\Coffee\Interfaces
 */
class Water extends AbstractContainer implements WaterContainer
{

    /**
     * @param float $litres
     * @throws ContainerFullException
     */
    public function addWater(float $litres) : void
    {
        $this->add($litres);
    }

    /**
     * @param float $litres
     * @return float
     */
    public function useWater(float $litres) : float
    {
        return $this->use($litres);
    }

    /**
     * @return float
     */
    public function getWater() : float
    {
        return $this->get();
    }
}