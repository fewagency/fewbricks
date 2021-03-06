<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithFields;

/**
 * Class Group
 * Corresponds to the group field type in ACF.
 *
 * @package Fewbricks\ACF\Fields
 */
class Group extends FieldWithFields implements FieldInterface
{

    const TYPE = 'group';

    /**
     * @return mixed The value of the ACF setting "layout". Returns the default ACF value "block" if none has been
     * set using Fewbricks.
     */
    public function get_layout()
    {

        return $this->get_setting('layout', 'block');

    }

    /**
     * ACF setting to specify the style used to render the selected fields.
     *
     * @param string $layout "block", "table" or "row"
     * @return $this
     */
    public function set_layout($layout)
    {

        return $this->set_setting('layout', $layout);

    }

}
