<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields\Extensions;

use Fewbricks\ACF\Fields\Extensions\Table;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class TableTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Extensions\Table';

    /**
     *
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(self::CLASS_NAME));
    }

    /**
     *
     */
    public function testAcfArray()
    {

        $settings = [
            // Used for creating the field object
            'label' => 'A field',
            'name' => 'name_of_the_field_et87giu',
            'key' => '1812101016a',
            // Internal test data that wil be removed when creating expected value
            'test__key_prefix' => '1812101016b',
            // These wil be set using setters on the field object
        ];

        $field = FieldHelper::getCompleteFieldObject(self::CLASS_NAME, $settings, $this);

        // Due to implementation fixes for this field type
        $settings['use_caption'] = 2;
        $settings['use_header'] = false;

        $this->assertEquals(
            FieldHelper::getExpectedFieldValues($field, $settings),
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetUseCaption()
    {

        $field = new Table('', '', '');

        $this->assertEquals(2, $field->getUseCaption());

        $field->setUseCaption(1);

        $this->assertEquals(1, $field->getUseCaption());

    }

    /**
     *
     */
    public function testSetAndGetUseHeader()
    {

        $field = new Table('', '', '');

        $this->assertEquals(0, $field->getUseHeader());

        $field->setUseHeader(2);

        $this->assertEquals(2, $field->getUseHeader());

    }

}
