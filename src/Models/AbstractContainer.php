<?php

namespace SoConnect\Coffee\Models;

use SoConnect\Coffee\Exceptions\ContainerFullException;

/**
 * Class AbstractContainer
 * @package SoConnect\Coffee\Models
 */
abstract class AbstractContainer
{

    /** @var $selectedSize */
    protected $selectedSize = 0;

    /** @var $total */
    protected $total = 0;

    /**
     * AbstractContainer constructor.
     * @param $total
     */
    public function __construct($total)
    {
        $this->selectedSize = $total;
    }

    /**
     * @param $value
     * @throws ContainerFullException
     */
    protected function add($value)
    {
        if (($this->total + $value) > $this->selectedSize) {
            throw new ContainerFullException('Container is full');
        }

        $this->total = $value;
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function use($value)
    {
        $this->total -= $value;

        return $this->total;
    }

    /**
     * @return mixed
     */
    protected function get()
    {
        return $this->total;
    }
}