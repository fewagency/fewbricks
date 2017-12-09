<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Textarea
 * Corresponds to the textarea field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Textarea extends Field implements FieldInterface
{

    /**
     * ACF setting.
     *
     * @param int $maxlength [sic]
     *
     * @return $this
     */
    public function setMaxlength($maxlength)
    {

        $this->setSetting('maxlength', $maxlength);

        return $this;

    }

    /**
     * ACF setting. Controls how new lines are rendered.
     *
     * @param string $newLines "wpautop", "br" or ""
     *
     * @return $this
     */
    public function setNewLines($newLines)
    {

        $this->setSetting('new_lines', $newLines);

        return $this;

    }

    /**
     * ACF setting.
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
     * ACF setting.
     *
     * @param int $rows
     *
     * @return $this
     */
    public function setRows($rows)
    {

        $this->setSetting('rows', $rows);

        return $this;

    }

    /**
     * @return mixed The value of the ACF setting "maxlength". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMaxlength()
    {

        return $this->getSetting('maxlength', '');

    }

    /**
     * @return mixed The value of the ACF setting "new_lines". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getNewLines()
    {

        return $this->getSetting('new_lines', '');

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
     * @return mixed The value of the ACF setting "rows". Returns the default ACF value 8 if none has been
     * set using Fewbricks.
     */
    public function getRows()
    {

        return $this->getSetting('rows', 8);

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'textarea';

    }

}
