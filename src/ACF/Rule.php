<?php

namespace Fewbricks\ACF;

/**
 * Class Rule
 *
 * @package Fewbricks\ACF
 */
class Rule
{

    /**
     * @var string
     */
    private $param;

    /**
     * @var string
     */
    private $operator;

    /**
     * @var string
     */
    private $value;

    /**
     * Rule constructor.
     *
     * @param string $param
     * @param string $operator
     * @param string|null $value
     */
    public function __construct($param, $operator, $value = null)
    {

        $this->param = $param;
        $this->operator = $operator;
        $this->value = $value;

    }

    /**
     * @return string
     */
    public function get_operator()
    {

        return $this->operator;

    }

    /**
     * @param string $operator
     * @return $this
     */
    public function set_operator(string $operator)
    {

        $this->operator = $operator;

        return $this;

    }

    /**
     * @return mixed
     */
    public function get_param()
    {

        return $this->param;

    }

    /**
     * @param string $param
     * @return $this
     */
    public function set_param($param)
    {

        $this->param = $param;

        return $this;

    }

    /**
     * @return mixed
     */
    public function get_value()
    {

        return $this->value;

    }

    /**
     * @param string $value
     * @return $this
     */
    public function set_value($value)
    {

        $this->value = $value;

        return $this;

    }

    /**
     * @return array An array that ACF can work with.
     */
    public function to_acf_array()
    {

        return ['param' => $this->param, 'operator' => $this->operator, 'value' => $this->value];

    }

}
