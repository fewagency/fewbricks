<?php

namespace Fewbricks\ACF;

use Fewbricks\ACF\Item;

/**
 * Class Field
 *
 * @package Fewbricks\ACF
 */
class Field extends Item
{

    /**
     * @var
     */
    protected $type;

    /**
     * Field constructor.
     *
     * @param string $label    The label of the field
     * @param string $name     The name of the field
     * @param string $key      The key of the field. Must be unique across the
     *                         entire app
     * @param array  $settings Array where you can pass all the possible
     *                         settings for the field.
     *                         https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-type%20settings
     * @param string $type     Name of a valid ACF field type
     */
    public function __construct($label, $name, $key, $settings = [], $type = '')
    {

        parent::__construct($label, $name, $key, $settings);

        // @todo Make sure that $type is declared
        if(!empty($type))
        {
            $this->setType($type);
        }

    }

    /**
     * @param array $conditionalLogic ACF setting. Conditionally hide or show
     *                                this field based on other field's values.
     *                                Best to use the ACF UI and export to
     *                                understand the array structure.
     *
     * @return $this
     */
    public function setConditionalLogic($conditionalLogic)
    {

        return $this->setSetting('conditional_logic', $conditionalLogic);

    }

    /**
     * @param mixed $defaultValue ACF setting. A default value used by ACF if no
     *                            value has yet been saved.
     *
     * @return $this
     */
    public function setDefaultValue($defaultValue)
    {

        return $this->setSetting('default_value', $defaultValue);

    }

    /**
     * @param string $instructions ACF setting. Instructions for authors.
     *                             Shown when submitting data
     *
     * @return $this
     */
    public function setInstructions($instructions)
    {

        return $this->setSetting('instructions', $instructions);

    }

    /**
     * @param boolean $required     ACF setting. Whether or not the field value
     *                              is required. If not set, false is used.
     *
     * @return $this
     */
    public function setRequired($required)
    {

        return $this->setSetting('required', $required);

    }

    /**
     * @param $type
     *
     * @return Field
     */
    public function setType($type)
    {

        $this->type = $type;

        return $this;

    }

    /**
     * @param boolean $wrapper ACF setting. An array of attributes given to the
     *                         field element in the backend.
     *
     * @return $this
     */
    public function setWrapper($wrapper)
    {

        // Make sure all indexes are set.
        $wrapper = array_merge([
            'width' => '',
            'class' => '',
            'id'    => '',
        ], $wrapper);

        return $this->setSetting('wrapper', $wrapper);

    }

    /**
     * @return array|boolean
     */
    public function getConditionalLogic()
    {

        return $this->getSetting('conditional_logic');

    }

    /**
     * @return string|boolean
     */
    public function getDefaultValue()
    {

        return $this->getSetting('default_value');

    }

    /**
     * @return string|boolean
     */
    public function getInstructions()
    {

        return $this->getSetting('instructions');

    }

    /**
     * @return boolean
     */
    public function getRequired()
    {

        return $this->getSetting('required');

    }

    /**
     * @return mixed
     */
    public function getType()
    {

        return $this->type;

    }

    /**
     * @return array|boolean
     */
    public function getWrapper()
    {

        return $this->getSetting('wrapper');

    }

    /**
     * @return array
     */
    public function toAcfArray()
    {

        $settings         = parent::toAcfArray();
        $settings['type'] = $this->getType();

        return $settings;

    }

}
