<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\DateTimeField;
use Fewbricks\ACF\FieldInterface;

/**
 * Class TimePicker
 * Corresponds to the time picker field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class TimePicker extends DateTimeField implements FieldInterface
{

    const TYPE = 'time_picker';

    /**
     * @return mixed The value of the ACF setting "display_format". Returns the default ACF value "g:i a" if none has
     * been
     * set using Fewbricks.
     */
    public function get_display_format()
    {

        return $this->get_setting('display_format', 'g:i a');

    }

    /**
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "g:i a" if none has
     * been
     * set using Fewbricks.
     */
    public function get_return_format()
    {

        return $this->get_setting('return_format', 'g:i a');

    }

}
