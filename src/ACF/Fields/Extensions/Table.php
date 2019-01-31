<?php

namespace Fewbricks\ACF\Fields\Extensions;

use Fewbricks\ACF\Field;

class Table extends Field
{

    const TYPE = 'table';

    /**
     * @param $useCaption 1 for "yes" or or 2 for "no"
     * @return $this
     */
    public function set_use_caption($useCaption)
    {

        return $this->set_setting('use_caption', $useCaption);

    }

    /**
     * @param $useHeader 0 for "optional", 1 for "yes" or or 2 for "no"
     * @return $this
     */
    public function set_use_header($useHeader)
    {

        return $this->set_setting('use_header', $useHeader);

    }

    /**
     * @return mixed
     */
    public function get_use_caption()
    {

        return $this->get_setting('use_caption', 2);

    }

    /**
     * @return mixed
     */
    public function get_use_header()
    {

        return $this->get_setting('use_header', 0);

    }

    /**
     * This function is called right before field is turned into ACF array.
     */
    protected function prepare_for_acf_array()
    {

        // Fix since the field does not check if indexes are set before using the value.
        if($this->get_setting('use_caption', false) === false) {
            $this->set_use_caption(2);
        }

        if($this->get_setting('use_header', false) === false) {
            $this->set_use_header(0);
        }

    }

}
