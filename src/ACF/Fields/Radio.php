<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithChoices;

/**
 * Class Radio
 * Corresponds to the radio field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Radio extends FieldWithChoices implements FieldInterface
{

    /**
     * ACF setting.
     *
     * @param string $layout "vertical" or "horizontal".
     *
     * @return $this
     */
    public function setLayout($layout)
    {

        return $this->setSetting('layout', $layout);

    }

    /**
     * @return string The ACF type
     */
    public function getType()
    {

        return 'radio';

    }

}