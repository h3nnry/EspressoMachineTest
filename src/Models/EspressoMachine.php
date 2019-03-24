<?php

namespace SoConnect\Coffee\Models;

use SoConnect\Coffee\Exceptions\ContainerFullException;
use SoConnect\Coffee\Exceptions\EspressoMachineException;
use SoConnect\Coffee\Exceptions\NoBeansException;
use SoConnect\Coffee\Exceptions\NoWaterException;
use SoConnect\Coffee\Interfaces\BeansContainer;
use SoConnect\Coffee\Interfaces\EspressoMachineInterface;
use SoConnect\Coffee\Interfaces\WaterContainer;

/**
 * Class EspressoMachine
 * @package SoConnect\Coffee\Models
 */
class EspressoMachine implements EspressoMachineInterface
{
    /** @var int  */
    const SINGLE_ESPRESSO_BEANS_NUMBER = 1;

    /** @var float  */
    const SINGLE_ESPRESSO_WATER_VOLUME = 0.05;

    /** @var int  */
    const DOUBLE_ESPRESSO_BEANS_NUMBER = 2;

    /** @var float  */
    const DOUBLE_ESPRESSO_WATER_VOLUME = 0.1;

    /** @var float  */
    const STANDART_WATER_CONTAINER_VOLUME = 2.0;

    /** @var float */
    const ATTACHED_WATER_CONTAINER_VOLUME = 10.0;

    /** @var int  */
    const STANDART_BEANS_CONTAINER_NUMBER = 50;

    /** @var int  */
    const ATTACHED_BEANS_CONTAINER_NUMBER = 200;

    /** @var WaterContainer */
    private $waterContainer;

    /** @var BeansContainer */
    private $beansContainer;

    /** @var float */
    private $volumeCoffeeMaid = 0.0;

    /** @var bool */
    private $waterSuppliedThroughPipes = false;

    /**
     * EspressoMachine constructor.
     */
    public function __construct() {
        $this->waterContainer = new Water(self::STANDART_WATER_CONTAINER_VOLUME);
        $this->beansContainer = new Beans(self::STANDART_BEANS_CONTAINER_NUMBER);
    }

    /**
     * @return float
     * @throws NoBeansException
     * @throws NoWaterException
     */
    public function makeEspresso() : float
    {
        return $this->prepareCoffee(self::SINGLE_ESPRESSO_WATER_VOLUME, self::SINGLE_ESPRESSO_BEANS_NUMBER);
    }

    /**
     * @return float
     * @throws NoBeansException
     * @throws NoWaterException
     */
    public function makeDoubleEspresso() : float
    {
        return $this->prepareCoffee(self::DOUBLE_ESPRESSO_WATER_VOLUME, self::DOUBLE_ESPRESSO_BEANS_NUMBER);
    }

    /**
     * @return string
     */
    public function getStatus() : string
    {
        if (!$this->waterSuppliedThroughPipes && $this->waterContainer->getWater() <= 0
            && $this->beansContainer->getBeans() <= 0) {
            return 'Need to supply machine with beans and water';
        }

        if (!$this->waterSuppliedThroughPipes && $this->waterContainer->getWater() <= 0) {
            return 'Need to supply machine with water';
        }

        if ($this->beansContainer->getBeans() <= 0) {
            return 'Need to supply machine with beans';
        }

        return $this->getNumberEspressoCanPrepare() . ' espresso to prepare';
    }

    /**
     * @param $litres
     * @throws EspressoMachineException
     */
    public function addWater($litres) :void
    {
        if (!$this->waterSuppliedThroughPipes) {
            try {
                $this->waterContainer->addWater($litres);
            }
            catch(ContainerFullException $e) {
                throw new EspressoMachineException($e->getMessage());
            }
        }
    }

    /**
     * @return float
     */
    public function getWater()
    {
        return $this->waterContainer->getWater();
    }

    /**
     * @param $numSpoons
     * @throws EspressoMachineException
     */
    public function addBeans($numSpoons) : void
    {
        try {
            $this->beansContainer->addBeans($numSpoons);
        }
        catch(ContainerFullException $e) {
            throw new EspressoMachineException($e->getMessage());
        }

    }

    /**
     * @return int
     */
    public function getBeans()
    {
        return $this->beansContainer->getBeans();
    }

    /**
     * @param float $waterVolume
     * @param int $beansNumber
     * @return float
     * @throws NoBeansException
     * @throws NoWaterException
     */
    private function prepareCoffee(float $waterVolume, int $beansNumber) : float
    {
        if (!$this->waterSuppliedThroughPipes && $this->waterContainer->getWater() < $waterVolume) {
            throw new NoWaterException();
        }

        if ($this->beansContainer->getBeans() < $beansNumber) {
            throw new NoBeansException();
        }
        
        $this->waterContainer->useWater($waterVolume);
        $this->beansContainer->useBeans($beansNumber);
        $this->volumeCoffeeMaid += $waterVolume;
        
        return $this->volumeCoffeeMaid;
    }

    /**
     * @return int
     */
    private function getNumberEspressoCanPrepare() : int
    {
        return $this->waterSuppliedThroughPipes
            ? $this->beansContainer->getBeans()
            :  min(
                $this->beansContainer->getBeans(),
                floor($this->waterContainer->getWater() / self::SINGLE_ESPRESSO_WATER_VOLUME)
            );

    }

    /**
     * Attach bigger container
     */
    public function attachBeanContainer() : void
    {
        $this->beansContainer->setSelectedSize(self::ATTACHED_BEANS_CONTAINER_NUMBER);
    }

    /**
     * Attach bigger container
     */
    public function attachWaterContainer() : void
    {
        $this->waterContainer->setSelectedSize( self::ATTACHED_WATER_CONTAINER_VOLUME);
    }

    /**
     * Set water supply through pipes
     */
    public function setWaterSupplyThroughPipes() : void
    {
        $this->waterSuppliedThroughPipes = true;
    }

    /**
     * Unset water supply through pipes
     */
    public function unsetWaterSupplyThroughPipes() : void
    {
        $this->waterSuppliedThroughPipes = false;
    }

}