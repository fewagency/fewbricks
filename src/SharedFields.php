<?php

namespace Fewbricks;

use Fewbricks\ACF\FieldCollection;

/**
 * Class SharedFields
 *
 * @package Fewbricks
 */
class SharedFields extends FieldCollection
{

    public function __construct(array $arguments = [])
    {
        parent::__construct($arguments);

        $this->applyFields();

    }

}
