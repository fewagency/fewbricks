<?php

/**
 * Demoing available filters
 */
namespace App\FewbricksDemo;

/**
 * Class Filters
 *
 * @package App\FewbricksDemo
 */
class Filters
{

    /**
     *
     */
    public static function defineHooks()
    {

        $me = get_class();

        // In a real project, this particular filter would have to be added outside the Fewbricks folder.
        // Like for example in functions.php
        /*add_filter('fewbricks/project_files_base_path',
            [$me . '\\Fewbricks', 'getProjectFilesBasePath']);*/

        add_filter('fewbricks/brick/brick_layout_base_path',
            [$me, 'getLayoutBasePath']);

        /*add_filter('fewbricks/brick/brick_template_base_path',
            [$me, 'getBrickTemplateBasePath']);*/

        add_filter('fewbricks/brick/brick_template_file_extension',
            [$me, 'getTemplateFileExtension']);

        add_action('admin_notices',
            [$me, 'editFieldGroupInfo']);

        add_filter('fewbricks/show_fields_info', '__return_true');

    }

    /**
     * This does not affect anything since the function is not called. Only here to show it should be done.
     * @return string
     */
    /*public static function getBrickTemplatesBasePath()
    {

        return get_stylesheet_directory() . '/fewbricks/bricks/';

    }*/

    /**
     * @return string
     */
    public static function getLayoutBasePath()
    {

        return get_template_directory() . '/templates/module-layouts';

    }

    /**
     * @return string
     */
    public static function getProjectFilesBasePath()
    {

        //return get_template_directory() . '/fewbricks2';
        return WP_PLUGIN_DIR . '/fewbricks/fewbricks';

    }

    /**
     * @return string
     */
    public static function getTemplateFileExtension()
    {

        return '.view.php';

    }

    /**
     *
     */
    public static function editFieldGroupInfo()
    {

        if (get_current_screen()->post_type === 'acf-field-group') {

            $message_html
                = '
                <div class="notice notice-info">
                    <p>If you are looking for field groups that you know should be here, please note that we are using <a href="https://github.com/folbert/fewbricks" target="_blank">Fewbricks</a> to create ACF-fields.</p>
                </div>';

            echo $message_html;

        }

    }

}
