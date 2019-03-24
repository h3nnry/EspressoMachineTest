namespace SoConnect\Coffee;

/**
 *
 * We drink a lot of coffee in the office...
 *
 * You challenge is to take the interface below and write a class that implements and fully complies to this interface
 *
 * We have already written a set of unit tests which will be used to test your implementation
 *
 * You MUST NOT change any of the existing methods defined in the interface
 * You should not print or display anything
 * You may add additional methods to your implementation
 * Exceptions are listed in the order of their priority
 * The standard WaterContainer contains 2 litres but other sizes can be attached. common sizes are the 10 litre or mains water supply
 * The standard BeanContainer holds 50 spoons of beans but other sizes can be attached.  a 200  bean container is common.
 *
 *
 */
class EspressoMachineException extends \Exception {}
class NoWaterException extends EspressoMachineException {}
class NoBeansException extends EspressoMachineException {}
class ContainerException extends \Exception {}
class ContainerFullException extends ContainerException {}

interface BeansContainer
{

    /**
     * Adds beans to the container
     *
     * @param integer $numSpoons number of spoons of beans
     * @throws ContainerFullException
     *
     * @return void
     */
    public function addBeans(int $numSpoons) : void;

    /**
     * Get $numSpoons from the container
     *
     * @param integer $numSpoons number of spoons of beans
     * @return integer
     */
    public function useBeans(int $numSpoons) : int;

    /**
     * Returns the number of spoons of beans left in the container
     *
     * @return integer
     */
    public function getBeans() : int;
}

interface WaterContainer
{

    /**
     * Adds water to the coffee machine's water tank
     *
     * @param float $litres
     * @throws ContainerFullException
     *
     * @return void
     */
    public function addWater(float $litres) : void;

    /**
     * Use $litres from the container
     *
     * @param float $litres
     * @return float
     */
    public function useWater(float $litres) : float;

    /**
     * Returns the volume of water left in the container
     *
     * @return float number of litres
     */
    public function getWater() : float;
}

/**
 * A single espresso uses 1 spoon of beans and 0.05 litres of water
 * A double espresso uses 2 spoons of beans and 0.10 litres of water
 *
 */
interface EspressoMachineInterface
{

    /**
     * Runs the process for making Espresso
     *
     * @throws NoBeansException, NoWaterException
     *
     * @return float of litres of coffee made
     */
    public function makeEspresso() : float;

    /**
     * @see makeEspresso
     * @throws NoBeansException, NoWaterException
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