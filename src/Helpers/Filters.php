<?php

namespace Fewbricks\Helpers;

class Filters {

    /**
     * @return bool
     */
    public static function dev_mode_is_enabled()
    {

        return \apply_filters('fewbricks/dev_mode/enable', false);

    }

    /**
     * @return bool
     */
    public static function field_snitch_is_enabled()
    {

        return apply_filters('fewbricks/show_fields_info', false);

    }

}
