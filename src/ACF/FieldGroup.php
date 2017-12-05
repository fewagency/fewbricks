<?php

namespace Fewbricks\ACF;

/**
 * Class FieldGroup
 *
 * @package Fewbricks\ACF
 */
class FieldGroup implements FieldGroupInterface
{

    /**
     * The items that ACF supports hiding as of v5.6.5
     */
    const HIDE_ON_SCREEN_ITEMS
        = [
            'permalink',
            'the_content',
            'excerpt',
            'custom_fields',
            'discussion',
            'comments',
            'revisions',
            'slug',
            'author',
            'format',
            'page_attributes',
            'featured_image',
            'categories',
            'tags',
            'send-trackbacks',
        ];

    /**
     * @var array An array enabling you to pass any argument that you need.
     */
    protected $args;

    /**
     * @var FieldCollection
     */
    private $fieldObjects;
    /**
     * @var
     */
    private $key;

    /**
     * @var RuleGroupCollection
     */
    private $locationRuleGroups;

    /**
     * @var
     */
    private $fieldNamesPrefix;

    /**
     * The array that actually makes up the field group since it holds all the
     * settings for the group
     *
     * @var array
     */
    private $settings;

    /**
     * @var
     */
    private $title;

    /**
     * FieldGroup constructor.
     *
     * @param string $title
     * @param string $key
     * @param array  $settings Any other settings that will affect ACF.
     *                         https://www.advancedcustomfields.com/resources/register-fields-via-php/#group-settings
     * @param array  $args     An array enabling you to pass any argument that you need.
     */
    public function __construct(
        $title,
        $key,
        $settings = [],
        $args = []
    ) {

        if (!is_array($settings)) {
            $settings = [];
        }

        // Let's keep these crucial settings as class vars to enable nicer
        // and more OOP-oriented access
        $this->title = $title;
        $this->key   = $key;

        $this->settings = $settings;

        if (!is_array($args)) {
            $args = [];
        }

        $this->args = $args;

        $this->fieldObjects = new FieldCollection();

        $this->clearLocationRuleGroups();

        $this->fieldNamesPrefix = '';

    }

    /**
     * @return $this
     */
    public function clearLocationRuleGroups()
    {

        $this->locationRuleGroups = new RuleGroupCollection();

        return $this;

    }

    /**
     * @param Field $field
     */
    public function addField($field)
    {

        $field->prefixName($this->fieldNamesPrefix);

        $this->fieldObjects->addItem($field);

    }

    /**
     * @param FieldGroupLocationRuleGroup[] $ruleGroups
     *
     * @return $this
     */
    public function addLocationRuleGroups($ruleGroups)
    {

        foreach ($ruleGroups AS $ruleGroup) {

            $this->addLocationRuleGroup($ruleGroup);

        }

        return $this;

    }

    /**
     * @param FieldGroupLocationRuleGroup $ruleGroup
     *
     * @return $this
     */
    public function addLocationRuleGroup($ruleGroup)
    {

        $this->locationRuleGroups->addItem($ruleGroup);

        return $this;

    }

    /**
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
     * @return FieldCollection
     */
    public function getFieldObjects()
    {

        return $this->fieldObjects;

    }

    /**
     * @return array
     */
    public function getSettings()
    {

        return $this->settings;

    }

    /**
     * Allow you to set which elements that should be hidden on screen.
     *
     * @see FieldGroup::setHideOnScreen()
     *
     * @param string|array $elementNames One or many of the values of the following: 'permalink', 'the_content',
     *                                   'excerpt', 'custom_fields', 'discussion', 'comments', 'revisions', 'slug',
     *                                   'author', 'format', 'page_attributes', 'featured_image', 'categories', 'tags',
     *                                   'send-trackbacks', 'all'. Note 'all' which will show all elements that
     *                                   ar possible to hide.
     *
     * @return $this
     */
    public function hideOnScreen($elementNames)
    {

        $this->setHideOnScreen($elementNames);

        return $this;

    }

    /**
     * ACF setting. An array of elements to hide on the screen.
     * Important: If multiple field groups appear on an edit screen, the first field group's options will be used
     * (the one with the lowest order number).
     *
     * Possible values in the array: 'permalink', 'the_content', 'excerpt', 'custom_fields', 'discussion',
     * 'comments', 'revisions', 'slug', 'author', 'format', 'page_attributes', 'featured_image', 'categories',
     * 'tags', 'send-trackbacks', 'all'
     *
     * @param array $hideOnScreen Array with items to hide on the screen.
     * @param array $showOnScreen Fewbricks addition. Enables you to define which fields should be visible on screen.
     *                            This will create an array with all the items that ACF supports hiding and then
     *                            remove the items that you have set in $showOnScreen. Passing a non-empty value here
     *                            will make the function ignore the $hideOnScreen variable completely
     *
     * @return $this
     */
    public function setHideOnScreen($hideOnScreen, $showOnScreen = [])
    {

        $currentValues = $this->getHideOnScreenSetting();

        if (!empty($showOnScreen)) {

            // If the user want to show all...
            if ($showOnScreen === 'all') {

                // ...we should hide nothing
                $hideOnScreen = [];

            } else {

                // Make sure we have an array
                if (!is_array($showOnScreen)) {
                    $showOnScreen = [$showOnScreen];
                }

                $hideOnScreen = array_diff($currentValues, $showOnScreen);

            }

        } else {

            // If the user want to hide all
            if ($hideOnScreen === 'all') {

                $hideOnScreen = self::HIDE_ON_SCREEN_ITEMS;

            } else {

                if (!is_array($hideOnScreen)) {
                    $hideOnScreen = [$hideOnScreen];
                }

                $hideOnScreen = array_merge($currentValues, $hideOnScreen);

            }

        }

        $this->setSetting('hide_on_screen', $hideOnScreen);

        return $this;

    }

    /**
     * @return array|bool|mixed
     */
    public function getHideOnScreenSetting()
    {

        // These are the items that ACF supports hiding as of v5.6.5
        $currentValues = $this->getSetting('hide_on_screen');

        // If the setting has not been set
        if ($currentValues === false) {

            $currentValues = self::HIDE_ON_SCREEN_ITEMS;

        }

        return $currentValues;

    }

    /**
     * Enables you to add values to the settings directly. So if ACF adds new settings, you don't have to wait for
     * Fewbricks to add functions for you to be able to set them.
     *
     * @param $name
     * @param $value
     *
     * @return $this
     */
    public function setSetting($name, $value)
    {

        $crucialSettings = ['key', 'title'];

        // Make sure to keep any crucial setting class vars up to date
        if (in_array($name, $crucialSettings)) {
            $this->{$name} = $value;
        }

        $this->settings[$name] = $value;

        return $this;

    }

    /**
     * Get the value of a specific setting.
     *
     * @param      $name         The name of the setting
     * @param bool $defaultValue The value to return if the setting does not exist
     *
     * @return bool|mixed
     */
    public function getSetting($name, $defaultValue = false)
    {

        $value = $defaultValue;

        if (isset($this->settings[$name])) {
            $value = $this->settings[$name];
        }

        return $value;

    }

    /**
     * @return RuleGroupCollection
     */
    public function getLocationRuleGroups()
    {

        return $this->locationRuleGroups;

    }

    /**
     * In order to keep in sync with ACFs namings, we have this function to call publicly. And then use doRegister()
     * to actually register.
     */
    public function register()
    {

        $this->build();

        $this->doRegister();

    }

    /**
     * @return mixed|void
     */
    public function build()
    {

    }

    /**
     *
     */
    protected function doRegister()
    {

        $acfSettingsArray = $this->toAcfArray();

        acf_add_local_field_group($acfSettingsArray);

        // No use in having a potentially large collection of objects anymore
        unset($this->fieldObjects);

    }

    /**
     * @return array
     */
    public function toAcfArray()
    {

        return array_merge($this->settings, [
            'key'      => $this->getKey(),
            'title'    => $this->getTitle(),
            'location' => $this->locationRuleGroups->toArray(),
            'fields'   => $this->fieldObjects->toArray($this->key),
        ]);

    }

    /**
     * @return string
     */
    public function getKey()
    {

        return $this->key;

    }

    /**
     * @return string
     */
    public function getTitle()
    {

        return $this->title;

    }

    /**
     * @param $title
     *
     * @return FieldGroup
     */
    public function setTitle($title)
    {

        $this->title = $title;

        return $this;

    }

    /**
     * ACF setting. If the field group should be registered or not.
     *
     * @param $active
     *
     * @return $this
     */
    public function setActive($active)
    {

        $this->setSetting('active', $active);

        return $this;

    }

    /**
     * @param null $defaultValue
     *
     * @return bool|mixed
     */
    public function getActive($defaultValue = null)
    {

        return $this->getSetting('active', $defaultValue);

    }

    /**
     * ACF setting. Shown in field group list. Since this is a setting that only affects the ACF GUI, it will probably
     * never be used by Fewbricks users. But lets add this function anyways just to be nice :)
     *
     * @param string $description The description
     *
     * @return $this
     */
    public function setDescription($description)
    {

        $this->setSetting('description', $description);

        return $this;

    }

    /**
     * @param string $defaultValue
     *
     * @return bool|mixed
     */
    public function getDescription($defaultValue = '')
    {

        return $this->getSetting('description', $defaultValue);

    }

    /**
     * ACF Setting. Determines where field instructions are placed in relation to fields.
     *
     * @param string $instruction_placement 'label' (Below labels) or 'field' (Below fields)
     *
     * @return $this
     */
    public function setInstructionPlacement($instruction_placement)
    {

        $this->setSetting('instruction_placement', $instruction_placement);

        return $this;

    }

    /**
     * @param bool $defaultValue
     *
     * @return bool|mixed
     */
    public function getInstructionPlacement($defaultValue = false)
    {

        return $this->getSetting('instruction_placement', $defaultValue);

    }

    /**
     * ACF Setting. Determines where field labels are placed in relation to fields. Defaults to 'top'.
     *
     * @param string $labelPlacement 'top' (Above fields) or 'left' (Beside fields)
     *
     * @return $this
     */
    public function setLabelPlacement($labelPlacement)
    {

        $this->setSetting('label_placement', $labelPlacement);

        return $this;


    }

    /**
     * @param $defaultVale
     *
     * @return bool|mixed
     */
    public function getLabelPlacement($defaultVale)
    {

        return $this->getSetting('label_placement', $defaultVale);

    }

    /**
     * ACF setting. Field groups are shown in order from lowest to highest.
     *
     * @param int $menuOrder
     *
     * @return $this
     */
    public function setMenuOrder($menuOrder)
    {

        $this->setSetting('menu_order', $menuOrder);

        return $this;

    }

    /**
     * @param $defaultValue
     *
     * @return bool|mixed
     */
    public function getMenuOrder($defaultValue)
    {

        return $this->getSetting('menu_order', $defaultValue);

    }

    /**
     * ACF setting. Determines the position on the edit screen. Defaults to 'normal'.
     *
     * @param string $position 'acf_after_title', 'normal' or 'side'
     *
     * @return $this
     */
    public function setPosition($position)
    {

        $this->setSetting('position', $position);

        return $this;

    }

    /**
     * @param $defaultValue
     *
     * @return bool|mixed
     */
    public function getPosition($defaultValue)
    {

        return $this->getSetting('position', $defaultValue);

    }

    /**
     * Determines the metabox style. Choices of 'default' or 'seamless'
     *
     * @param string $style 'default' or 'seamless'
     *
     * @return $this
     */
    public function setStyle($style)
    {

        $this->setSetting('style', $style);

        return $this;

    }

    /**
     * @param bool $defaultValue
     *
     * @return bool|mixed
     */
    public function getStyle($defaultValue = false)
    {

        return $this->getSetting('style', $defaultValue);

    }

    /**
     * If the element has been previously set to be hidden, this will set it to be shown instead.
     *
     * @see FieldGroup::hideOnScreen()
     *
     * @param string|array $elementNames One or many of the values of the following: 'permalink', 'the_content',
     *                                   'excerpt', 'custom_fields', 'discussion', 'comments', 'revisions', 'slug',
     *                                   'author', 'format', 'page_attributes', 'featured_image', 'categories', 'tags',
     *                                   'send-trackbacks', 'all'. Note 'all' which will show all elements that
     *                                   ar possible to hide.
     *
     * @return $this
     */
    public function showOnScreen($elementNames)
    {

        $this->setHideOnScreen([], $elementNames);

        return $this;

    }

}
