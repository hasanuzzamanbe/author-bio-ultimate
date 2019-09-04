<?php

/*
Plugin Name: Author Bio- Show Author Bio easily
Plugin URI: https://github.com/hasanuzzamanbe/Chart-Maker
Description: Create your data Author Bio within a minute.
Version: 1.0.0
Author: Xaaman
Author URI: https://github.com/hasanuzzamanbe
License: A "Slug" license name e.g. GPL2
Text Domain: authorbio
*/


/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright 2019 WPManageNinja LLC. All rights reserved.
 */

if (!defined('ABSPATH')) {
    exit;
}
if (!defined('AUTHORBIO_VERSION')) {
    define('AUTHORBIO_VERSION_LITE', true);
    define('AUTHORBIO_VERSION', '1.1.0');
    define('AUTHORBIO_MAIN_FILE', __FILE__);
    define('AUTHORBIO_URL', plugin_dir_url(__FILE__));
    define('AUTHORBIO_DIR', plugin_dir_path(__FILE__));
    define('AUTHORBIO_UPLOAD_DIR', '/authorbio');

    class AuthorBio
    {
        public function boot()
        {
            if (is_admin()) {
                $this->adminHooks();
            }
        }

        public function adminHooks()
        {
            require AUTHORBIO_DIR.'includes/autoload.php';

            //Register Admin menu
            $menu = new \AuthorBio\Classes\Menu();
            $menu->register();

            $globalSettingHandler = new \AuthorBio\Classes\GlobalSettingsHandler();
            $globalSettingHandler->registerHooks();

            add_action('authorbio/render_admin_app', function () {
                $adminApp = new \AuthorBio\Classes\AdminApp();
                $adminApp->bootView();
            });
            wp_enqueue_style('authorbio_admin_app', AUTHORBIO_URL.'dist/admin/css/author-bio-admin.css', array(), AUTHORBIO_VERSION);
          
            wp_enqueue_script(
                'author_bio_settings_boot',
                AUTHORBIO_URL . 'dist/js/boot.js',
                array( 'jquery' ),
                AUTHORBIO_VERSION,
                true
            );
        }

        public function textDomain()
        {
            load_plugin_textdomain('authorbio', false, basename(dirname(__FILE__)) . '/languages');
        }

    }

    add_action('plugins_loaded', function () {
        (new AuthorBio())->boot();
    });

    register_activation_hook(__FILE__, function ($newWorkWide) {
        require_once(AUTHORBIO_DIR . 'includes/Classes/Activator.php');
        $activator = new \AuthorBio\Classes\Activator();
        $activator->migrateDatabases($newWorkWide);
    });

} else {
    add_action('admin_init', function () {
        deactivate_plugins(plugin_basename(__FILE__));
    });
}
