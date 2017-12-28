<?php

namespace Fewbricks\ACF;

use Fewbricks\Brick;
use Fewbricks\Collection;
use Fewbricks\SharedFields;

/**
 * Class FieldCollection
 *
 * @package Fewbricks\ACF
 */
class FieldCollection extends Collection
{

    /**
     * @var
     */
    protected $args;

    /**
     * @var
     */
    private $fieldLabelsPrefix;

    /**
     * @var
     */
    private $fieldLabelsSuffix;

    /**
     * @var string
     */
    private $fieldNamesPrefix;

    /**
     * @var array
     */
    private $fieldsSettings;

    /**
     * @var array
     */
    private $fieldsToRemove;

    /**
     * @var array
     */
    private $fieldsToAddAfterFieldsOnBuild;

    /**
     * @var array
     */
    private $fieldsToAddBeforeFieldsOnBuild;

    /**
     * FieldCollection constructor.
     *
     * @param $args
     */
    public function __construct($args = [])
    {


        if (!is_array($args)) {
            $args = [];
        }

        $this->args = $args;

        $this->fieldNamesPrefix               = '';
        $this->fieldLabelsPrefix              = '';
        $this->fieldLabelsSuffix              = '';
        $this->fieldsToRemove                 = [];
        $this->fieldsToAddAfterFieldsOnBuild  = [];
        $this->fieldsToAddBeforeFieldsOnBuild = [];
        $this->fieldsSettings                 = [];

        parent::__construct();

    }

    /**
     * @param Brick $brick
     *
     * @return $this
     * @throws \Fewbricks\KeyInUseException
     */
    public function addBrick($brick)
    {

        $brick->setFields();

        dump($brick->fieldsSettings);

        /** @var Field $field */
        foreach ($brick->getFields() AS $field) {

            // Apply extra settings here? As an extra array on the field object?

            $this->addField($field);

        }

        return $this;

    }

    /**
     * @param Field $field
     *
     * @return $this
     * @throws \Fewbricks\KeyInUseException
     */
    public function addField($field)
    {

        $field->prefixName($this->fieldNamesPrefix);
        $field->prefixLabel($this->fieldLabelsPrefix);
        $field->suffixLabel($this->fieldLabelsSuffix);

        try {

            $this->addItem($field, $field->getKey());

        } catch (KeyInUseException $keyInUseException) {

            $keyInUseException->wpDie();

        }

        return $this;

    }

    /**
     * @param Field  $field
     * @param string $fieldNameToAddAfter
     *
     * @return FieldGroup
     */
    public function addFieldAfter($field, $fieldNameToAddAfter)
    {

        $this->fieldsToAddAfterFieldsOnBuild[] = [$field, $fieldNameToAddAfter];

        return $this;

    }

    /**
     * @param Field  $field
     * @param string $fieldNameToAddBefore
     *
     * @return FieldGroup
     */
    public function addFieldBefore($field, $fieldNameToAddBefore)
    {

        $this->fieldsToAddBeforeFieldsOnBuild[] = [$field, $fieldNameToAddBefore];

        return $this;

    }

    /**
     * Set ACF settings on fields in this collection. The values will be applied as they are so don't use this to set
     * keys or conditional logic.
     *
     * @param array $fieldKey       The original key (the one set when a field was created) of a field in this collection..
     * @param       $settingsName   Should correspond to teh name of an ACF setting
     * @param       $settingsValue  A valid value for the setting
     *
     * @return FieldCollection
     */
    public function addFieldSetting($fieldKey, $settingsName, $settingsValue)
    {

        if (!isset($this->fieldsSettings[$fieldKey])) {

            $this->fieldsSettings[$fieldKey] = [];

        }

        $this->fieldsSettings[$fieldKey][$settingsName] = $settingsValue;

        return $this;

    }

    /**
     * @param array|FieldCollection $fields
     *
     * @throws \Fewbricks\KeyInUseException
     */
    public function addFields($fields)
    {

        if (is_array($fields)) {

            foreach ($fields AS $field) {
                $this->addField($field);
            }

        } else {

            $this->addFields($fields->getItems());

        }

    }

    /**
     * @param $item
     * @param $nameToAddAfter
     */
    public function addItemAfterByName($item, $nameToAddAfter)
    {

        /** @var Field $itemToAddAfter */
        $itemToAddAfter = $this->getItemByName($nameToAddAfter);

        if ($itemToAddAfter !== false) {

            $this->addItemAfter($item, $itemToAddAfter->getKey());

        }

    }

    /**
     * @param $item
     * @param $nameToAddBefore
     */
    public function addItemBeforeByName($item, $nameToAddBefore)
    {

        /** @var Field $itemToAddAfter */
        $itemToAddBefore = $this->getItemByName($nameToAddBefore);

        if ($itemToAddBefore !== false) {

            $this->addItemBefore($item, $itemToAddBefore->getKey());

        }

    }

    /**
     *
     */
    protected function doAddFieldsAfter()
    {

        foreach ($this->fieldsToAddAfterFieldsOnBuild AS $data) {

            $this->addItemAfterByName($data[0], $data[1]);

        }

    }

    /**
     *
     */
    protected function doAddFieldsBefore()
    {

        foreach ($this->fieldsToAddBeforeFieldsOnBuild AS $data) {

            $this->addItemBeforeByName($data[0], $data[1]);

        }

    }

    /**
     *
     */
    protected function doRemoveFields()
    {

        foreach ($this->fieldsToRemove AS $fieldToRemove) {

            $this->removeItemByName($fieldToRemove);

        }

    }

    /**
     * @param Field[] $fieldObjects
     * @param string  $base_key
     *
     * @return array Associative array with field settings ready to be used for
     * "fields" in an array to be sent to ACFs functions for
     * registering fields using code.
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/#example
     */
    private function finalizeSettings($fieldObjects, $base_key)
    {

        $settings = [];

        foreach ($fieldObjects AS $fieldObject) {

            $keyPrepend = $base_key;

            // If the field belongs to a brick
            if (false !== ($brickKey = $fieldObject->getBrickKey())) {
                $keyPrepend .= '_' . $brickKey;
            }

            $keyPrepend .= '_';

            $fieldObject->prefixKey($keyPrepend);

            dump($this->fieldsSettings);

            $extraSettings = (isset($this->fieldsSettings[$fieldObject->getOriginalKey()])
                ? $this->fieldsSettings[$fieldObject->getOriginalKey()] : ['apa' => 'banan']);

            $acfArray = $fieldObject->getAcfArray($extraSettings);

            $settings[] = $acfArray;

        }

        $settings = $this->prepareFieldsConditionalLogic($settings);

        return $settings;

    }

    /**
     * @param string $baseKey
     *
     * @return array An array that ACF can work with.
     */
    public function getAcfArray($baseKey)
    {

        $this->doRemoveFields();
        $this->doAddFieldsAfter();
        $this->doAddFieldsBefore();

        // Lets make sure that the key is ok for ACF
        // https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-settings
        if (substr($baseKey, 0, 6) !== 'field_') {
            $baseKey = 'field_' . $baseKey;
        }

        return $this->finalizeSettings($this->items, $baseKey);

    }

    /**
     * @param string $name
     * @param null   $defaultValue Value to return if arg is not set
     *
     * @return mixed|null
     */
    public function getArg($name, $defaultValue = null)
    {

        return (isset($this->args[$name]) ? $this->args[$name] : $defaultValue);

    }

    /**
     * @return mixed
     */
    public function getFields()
    {

        return $this->getItems();

    }

    /**
     * @param $name
     *
     * @return bool|mixed
     */
    public function getItemByName($name)
    {

        $item = false;

        /**
         * @var string $item_key
         * @var Field  $field
         */
        foreach ($this->items AS $item_key => $field) {

            if ($field->getName() === $name) {

                $item = parent::getItem($item_key);

            }

        }

        return $item;

    }

    /**
     * @param array $fieldsSettings
     *
     * @return mixed
     */
    private function prepareFieldsConditionalLogic($fieldsSettings)
    {

        foreach ($fieldsSettings AS $fieldSettingsKey => $fieldSettings) {

            // Do the field have conditional logic
            if (isset($fieldSettings['conditional_logic'])
                && is_array($fieldSettings['conditional_logic'])
            ) {

                $conditionalLogic = $fieldSettings['conditional_logic'];

                // Traverse down the conditional logic array
                foreach ($conditionalLogic AS $conditionalLogicGroupKey => $conditionalLogicGroupValue) {

                    foreach (
                        $conditionalLogic[$conditionalLogicGroupKey] AS $conditionalLogicItemKey =>
                        $conditionalLogicItemValue
                    ) {

                        $targetFieldKey
                            = $conditionalLogic[$conditionalLogicGroupKey][$conditionalLogicItemKey]['field'];

                        // Loop all other items in this collection
                        foreach ($this->items AS $otherFieldObject) {

                            if ($otherFieldObject->getOriginalKey() === $targetFieldKey) {

                                $conditionalLogic[$conditionalLogicGroupKey][$conditionalLogicItemKey]['field']
                                    = $otherFieldObject->getKey();

                            }

                        }

                    }

                }

                $fieldsSettings[$fieldSettingsKey]['conditional_logic'] = $conditionalLogic;

            }

        }

        return $fieldsSettings;

    }

    /**
     * @param string $fieldName The name of a field. Not the key, not the label, the name.
     *
     * @return FieldGroup
     */
    public function removeField($fieldName)
    {

        // Use the field name as index to allow us to use isset() later on which is faster than in_array
        // https://stackoverflow.com/questions/13483219/what-is-faster-in-array-or-isset
        $this->fieldsToRemove[$fieldName] = $fieldName;

        return $this;

    }

    /**
     * @param $fieldNames
     *
     * @return FieldGroup
     */
    public function removeFields($fieldNames)
    {

        foreach ($fieldNames AS $fieldName) {

            $this->removeField($fieldName);

        }

        return $this;

    }

    /**
     * @param $name
     */
    public function removeItemByName($name)
    {

        /** @var Field $field */
        foreach ($this->items AS $item_key => $field) {

            if ($field->getName() === $name) {

                parent::removeItem($item_key);

            }

        }

    }

    /**
     * @param string $name
     * @param        $value
     *
     * @return $this
     */
    public function setArg($name, $value)
    {

        $this->args[$name] = $value;

        return $this;

    }

    /**
     * Set a string that will be prefixed to the labels of the fields that are added to this field group.
     *
     * @param $prefix
     *
     * @return $this
     */
    public function setFieldLabelsPrefix($prefix)
    {

        $this->fieldLabelsPrefix = $prefix;

        return $this;

    }

    /**
     * Set a string that will be prefixed to the names of the fields that are added to this field group.
     *
     * @param string $prefix
     *
     * @return $this
     */
    public function setFieldNamesPrefix($prefix)
    {

        $this->fieldNamesPrefix = $prefix;

        return $this;

    }

    /**
     * If you change your mind about removing a field, use this function to un-remove it. Since we are not actually
     * adding a field, we are un-removing it.
     *
     * @param string $fieldName
     *
     * @return FieldGroup
     */
    public function unRemoveField($fieldName)
    {

        unset($this->fieldsToRemove[$fieldName]);

        return $this;

    }

    /**
     * @param $fieldNames
     *
     * @return $this
     */
    public function unRemoveFields($fieldNames)
    {

        foreach ($fieldNames AS $fieldName) {

            $this->unRemoveField($fieldName);

        }

        return $this;

    }

}
