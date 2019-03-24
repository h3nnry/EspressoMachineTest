<?php

namespace SoConnect\Coffee\Interfaces;

use SoConnect\Coffee\Exceptions\NoBeansException;
use SoConnect\Coffee\Exceptions\NoWaterException;

/**
 * Interface EspressoMachineInterface
 * @package SoConnect\Coffee\Interfaces
 *
 * A single espresso uses 1 spoon of beans and 0.05 litres of water
 * A double espresso uses 2 spoons of beans and 0.10 litres of water
 */
interface EspressoMachineInterface
{

    /**
     * Runs the process for making Espresso
     *
     * @throws NoBeansException
     * @throws NoWaterException
     *
     * @return float of litres of coffee made
     */
    public function makeEspresso() : float;

    /**
     * @see makeEspresso
     * @throws NoBeansException
     * @throws NoWaterException
     *
     * @return float of litres of coffee made
     */
    public function makeDoubleEspresso() : float;

    /**
     * This method controls what is displayed on the screen of the machine
     * Returns ONE of the following human readable statuses in the following preference order:
     *
     * Add beans and water
     * Add beans
     * Add water
     * {Integer} Espressos left
     *
     * @return string
     */
    public function getStatus() : string;

}