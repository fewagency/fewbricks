<?php

namespace FewbricksDemo\FieldGroups;

use Fewbricks\ACF\FieldGroup;
use FewbricksDemo\Bricks\AcfCoreFields;
use FewbricksDemo\Bricks\ExtensionFields;

class AllFields extends FieldGroup
{

    public function set_up()
    {

        $this->add_brick(new AcfCoreFields('core_fields', '1812032253a'));
        $this->add_brick(new ExtensionFields('extension_fields', '1812032312a'));

        $this->set_menu_order(10)
            ->set_display_in_fewbricks_dev_tools(true)
            ->set_hide_on_screen('all');

        return $this;

    }

}
