<?php

namespace AuthorBio\Classes;


class Menu
{
    public function register()
    {
        add_action( 'admin_menu', array($this, 'addMenus') );
    }

    public function addMenus()
    {
        $menuPermission = AccessControl::hasTopLevelMenuPermission();
        if (!$menuPermission) {
            return;
        }

        $title = __('Author Bio', 'authorbio');
        global $submenu;
        add_menu_page(
            $title,
            $title,
            $menuPermission,
            'authorbio.php',
            array($this, 'render'),
            'dashicons-admin-users',
            25
        );

        $submenu['authorbio.php']['my_profile'] = array(
            __('My Profile', 'authorbio'),
            $menuPermission,
            'admin.php?page=authorbio.php#/',
        );
        $submenu['authorbio.php']['settings'] = array(
            __('Settings', 'authorbio'),
            $menuPermission,
            'admin.php?page=authorbio.php#/settings',
        );
        $submenu['authorbio.php']['supports'] = array(
            __('Supports', 'authorbio'),
            $menuPermission,
            'admin.php?page=authorbio.php#/supports',
        );
    }

    public function render() {
        do_action('authorbio/render_admin_app');
        wp_enqueue_script(
            'chart-maker',
            AUTHORBIO_URL . 'dist/js/author-bio.js',
            array( 'jquery' ),
            AUTHORBIO_VERSION,
            true
        );
    }

}
