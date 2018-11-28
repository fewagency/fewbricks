<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithChoices;

/**
 * Class Checkbox
 * Corresponds to the checkbox group field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Checkbox extends FieldWithChoices implements FieldInterface
{

    const MY_TYPE = 'checkbox';

    /**
     * @return mixed The value of the ACF setting "allow_custom". Returns the default ACF value "0" if none has been
     * set using Fewbricks.
     */
    public function getAllowCustom()
    {

        return $this->getSetting('allow_custom', false);

    }

    /**
     * @return mixed The value of the ACF setting "save_custom". Returns the default ACF value "0" if none has been
     * set using Fewbricks.
     */
    public function getSaveCustom()
    {

        return $this->getSetting('save_custom', false);

    }

    /**
     * @return mixed The value of the ACF setting "toggle". Returns the default ACF value "false" if none has been
     * set using Fewbricks.
     */
    public function getToggle()
    {

        return $this->getSetting('toggle', false);

    }

    /**
     * ACF setting.
     *
     * @param boolean $allowCustom
     * @return $this
     */
    public function setAllowCustom($allowCustom)
    {

        return $this->setSetting('allow_custom', $allowCustom);

    }

    /**
     * ACF setting
     *
     * @param string $layout vertical or horizontal
     * @return $this
     */
    public function setLayout($layout)
    {

        return $this->setSetting('layout', $layout);

    }

    /**
     * ACF setting.
     *
     * @param boolean $saveCustom
     * @return $this
     */
    public function setSaveCustom($saveCustom)
    {

        return $this->setSetting('save_custom', $saveCustom);

    }

    /**
     * ACF setting. Send true to prepend an extra checkbox to toggle all choices.
     *
     * @param boolean $toggle
     * @return $this
     */
    public function setToggle($toggle)
    {

        return $this->setSetting('toggle', $toggle);

    }

}
