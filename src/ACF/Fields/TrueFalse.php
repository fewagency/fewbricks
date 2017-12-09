<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class TrueFalse
 * Corresponds to the true false field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class TrueFalse extends Field implements FieldInterface
{

    /**
     * @return $this
     */
    public function setMessage($message)
    {

        $this->setSetting('message', $message);

        return $this;

    }

    /**
     * @param $ui
     *
     * @return $this
     */
    public function setUi($ui)
    {

        $this->setSetting('ui', $ui);

        return $this;

    }

    /**
     * @return mixed The value of the ACF setting "default_value". Returns the default ACF value false" if none has been
     * set using Fewbricks.
     */
    public function getDefaultValue()
    {

        return $this->getSetting('default_value', false);

    }

    /**
     * @return mixed The value of the ACF setting "message". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMessage()
    {

        return $this->getSetting('message', '');

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'true_false';

    }

    /**
     * @return mixed The value of the ACF setting "ui". Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function getUi()
    {

        return $this->getSetting('ui', false);

    }

}
