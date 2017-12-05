<?php

namespace Fewbricks\ACF;

/**
 * Class ItemWithSubFields
 *
 * @package Fewbricks\ACF
 */
class FieldWithSubFields extends Field
{

    /**
     * @var FieldCollection
     */
    protected $subFields;

    /**
     * FieldWithSubFields constructor.
     *
     * @param string $label
     * @param string $name
     * @param string $key
     * @param array  $settings
     */
    public function __construct(
        $label,
        $name,
        $key,
        array $settings = []
    ) {

        parent::__construct($label, $name, $key, $settings);

        $this->subFields = new FieldCollection();

    }

    /**
     * @param Field $field
     * @param null  $key
     *
     * @return $this
     */
    public function addSubField($field, $key = null)
    {

        $this->subFields->addItem($field, $key);

        return $this;

    }

    /**
     * @param int $key
     *
     * @return $this
     */
    public function deleteSubField($key)
    {

        $this->subFields->deleteItem($key);

        return $this;

    }

    /**
     * @return array
     */
    public function toAcfArray()
    {

        $settings = parent::toAcfArray();

        $settings['sub_fields'] = $this->subFields->toArray($this->key);

        return $settings;

    }

    /**
     * @param int $key
     *
     * @return mixed
     */
    public function getSubField($key)
    {

        return $this->subFields->getItem($key);

    }

    /**
     * @return FieldCollection
     */
    public function getSubFields()
    {

        return $this->subFields;

    }

}
