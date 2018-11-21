<?php

namespace Fewbricks;

/**
 * Class Fewbricks
 *
 * @package Fewbricks
 */
class Fewbricks
{

    /**
     *
     */
    public static function applyHooks()
    {

        add_action('wp_loaded', __NAMESPACE__ . '\\Helper::maybeWriteToPhpCodeFile');

    }

    /**
     * Makes sure that all requirements are met and if not, displays an error message
     * indicating what the problem is.
     *
     * @param bool $display_message
     *
     * @return bool Whether or not the requirements are met.
     */
    private static function checkRequirements($display_message = true)
    {

        $message = false;

        if (!Helper::acfIsActivated()) {

            $message
                = sprintf(__('You have activated the plugin "Fewbricks". In order to use it, please make sure that <a href="%1$s">Advanced Custom Fields 5 Pro</a> is installed and activated.',
                'fewbricks'), 'http://www.advancedcustomfields.com/');

        } else if (!Helper::fewbricksHiddenIsActivated()) {

            $message
                = sprintf(__('You have activated the plugin "Fewbricks". In order to use it, please make sure that %1$s is installed and activated.',
                'fewbricks'),
                '<a href="https://github.com/folbert/acf-fewbricks-hidden">Fewbricks Hidden Field</a> for Advanced Custom Fields');

        } else if (!Helper::projectInitFileExists()) {

            $message
                = sprintf(__('You have activated the plugin "Fewbricks". In order to use it, please make sure that you have copied the directory "fewbricks" in plugins/fewbricks/ to your theme directory or placed it at the path that you have specified using the filter fewbricks/project_files_base_path (currently <code>%1$s</code>). Also make sure that there is a file in that directory named "init.php"'),
                Helper::getProjectFilesBasePath());

        }

        if ($display_message && $message !== false) {

            add_action('admin_notices', function () use ($message) {
                echo '<div class="notice notice-warning"><p>' . $message . '</p></div>';
            });

        }

        // If no message, all is good
        return ($message === false);

    }

    /**
     *
     */
    public static function displayNotices()
    {

        $message = false;

        if (Helper::projectBasePathIsDefault()) {

            $message
                = sprintf(__('You have activated the plugin "Fewbricks". At the moment it is looking for project-specific files in (<code>'
                             . Helper::getProjectFilesBasePath()
                             . '</code>). Since this folder will be overwritten on plugin updates, you should create your own project/app/theme/whatchamacallit specific Fewbricks directory somewhere safe like in a functionality plugin or in your theme. Whatever you choose, feel free to make a copy of the fewbricks-demo directory and base your custom code on that. After you have copied the folder, you must use the filter <code>fewbricks/project_files_base_path</code> to set the path where your project specific files resides. See <a href="https://fewbricksdocs.readme.io" target="_blank">the documentation</a> for more info on available filters.'));

        }

        if ($message !== false) {

            add_action('admin_notices', function () use ($message) {
                echo '<div class="notice notice-warning"><p>' . $message . '</p></div>';
            });

        }

    }

    /**
     *
     */
    private static function init()
    {

        self::displayNotices();

        /** @noinspection PhpIncludeInspection */
        require Helper::getProjectInitFilePath();

        Helper::initDebug();

    }

    /**
     * Start me up!
     */
    public static function run()
    {

        // Only perform requirement checks in admin system.
        // If any requirements are not met, this should be discovered by devs before pushing to production so let's save
        // some CPU cycles on the frontend by not running all these checks there.
        if (!is_admin() || (is_admin() && self::checkRequirements())) {

            self::init();

        }

        if (is_admin()) {
            Admin::applyHooks();
        }

        self::applyHooks();

    }

}
