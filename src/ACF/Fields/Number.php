<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Number
 * Corresponds to the number field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Number extends Field implements FieldInterface
{

    /**
     * ACF setting. Appears after the input.
     *
     * @param string $append
     *
     * @return $this
     */
    public function setAppend($append)
    {

        $this->setSetting('append', $append);

        return $this;

    }

    /**
     * ACF setting.
     *
     * @param int $maximumValue
     *
     * @return $this
     */
    public function setMaximumValue($maximumValue)
    {

        $this->setSetting('max', $maximumValue);

        return $this;

    }

    /**
     * ACF setting.
     *
     * @param int $minimumValue
     *
     * @return $this
     */
    public function setMinimumValue($minimumValue)
    {

        $this->setSetting('min', $minimumValue);

        return $this;

    }

    /**
     * ACF setting. Set the placeholder for the field
     *
     * @param string $placeholder
     *
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {

        $this->setSetting('placeholder', $placeholder);

        return $this;

    }

    /**
     * ACF setting. Appears before the input.
     *
     * @param string $prepend
     *
     * @return $this
     */
    public function setPrepend($prepend)
    {

        $this->setSetting('prepend', $prepend);

        return $this;

    }

    /**
     * ACF setting.
     *
     * @param int $step
     *
     * @return $this
     */
    public function setStep($step)
    {

        $this->setSetting('step', $step);

        return $this;

    }

    /**
     * @return mixed The value of the ACF setting "append". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getAppend()
    {

        return $this->getSetting('append', '');

    }

    /**
     * @return mixed The value of the ACF setting "maximum_value". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMaximumValue()
    {

        return $this->getSetting('maximum_value', '');

    }

    /**
     * @return mixed The value of the ACF setting "minimum_value". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMinimumValue()
    {

        return $this->getSetting('minimum_value', '');

    }

    /**
     * @return mixed The value of the ACF setting "placeholder". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getPlaceholder()
    {

        return $this->getSetting('placeholder', '');

    }

    /**
     * @return mixed The value of the ACF setting "prepend". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getPrepend()
    {

        return $this->getSetting('prepend', '');

    }

    /**
     * @return mixed The value of the ACF setting "step". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getStep()
    {

        return $this->getSetting('step', '');

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'number';

    }

}