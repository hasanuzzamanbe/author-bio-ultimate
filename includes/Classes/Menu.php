<?php

namespace AuthorBio\Classes;


class Menu
{
    public function register()
    {
        add_action( 'admin_menu', array($this, 'addMenus') );
        add_action('admin_enqueue_scripts', array($this, 'enqueueAssets'));
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

    public function enqueueAssets()
    {
        if (function_exists('wp_enqueue_editor')) {
            wp_enqueue_editor();
            wp_enqueue_script('thickbox');
        }
        if (function_exists('wp_enqueue_media')) {
            wp_enqueue_media();
        }

        wp_enqueue_script(
            'author_bio_settings_boot',
            AUTHORBIO_URL . 'dist/js/boot.js',
            array( 'jquery' ),
            AUTHORBIO_VERSION,
            true
        );
        wp_enqueue_script(
            'author-bio',
            AUTHORBIO_URL . 'dist/js/author-bio.js',
            array( 'author_bio_settings_boot' ),
            AUTHORBIO_VERSION,
            true
        );
        wp_enqueue_style('authorbio_admin_app',
            AUTHORBIO_URL.'dist/admin/css/author-bio-admin.css',
            array(), AUTHORBIO_VERSION
        );


        $user_id = get_current_user_id();

        $author_des = get_the_author_meta('user_description', $user_id);
        $avatar_link = get_avatar_url( $user_id, ['size' => '178'] );
        $authorBioAdminVars = apply_filters('authorbio/admin_app_vars', array(
            'i18n'                => array(
                'All Author' => __('All Author', 'authorbio')
            ),
            'assets_url'          => AUTHORBIO_URL . 'dist/',
            'ajaxurl'             => admin_url('admin-ajax.php'),
            'avatar'              => $avatar_link,
            'ace_path_url'        => AUTHORBIO_URL.'dist/libs/ace',
            'author_des'          => $author_des,
            'author_id'          => $user_id,
            'image_upload_url'    => admin_url('admin-ajax.php?action=author_bio_global_settings_handler&route=author_bio_upload_image')
        ));
        wp_localize_script('author_bio_settings_boot', 'authorBioAdmin', $authorBioAdminVars);

    }
    
    public function render() {
        do_action('authorbio/render_admin_app');
    }

}
