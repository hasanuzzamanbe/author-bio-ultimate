<?php

namespace AuthorBio\Classes\Integrations;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Button To TinyMCE Editor
 *
 * @since 1.0.0
 */

class TinyMceBlock
{
    public function register()
    {
        $pages_with_editor_button = array('post.php', 'post-new.php');
        foreach ($pages_with_editor_button as $editor_page) {
            add_action("load-{$editor_page}", array($this, 'registerButton'));
        }
    }

    public function registerButton()
    {
        // Check if the logged in WordPress User can edit Posts or Pages
        // If not, don't register our TinyMCE plugin
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }

        // Check if the logged in WordPress User has the Visual Editor enabled
        // If not, don't register our TinyMCE plugin
        if (get_user_option('rich_editing') !== 'true') {
            return;
        }

        // We are adding localized vars here
        wp_localize_script('jquery','auth_bio_tinymce_vars', array(
            "label" => __('Select an Event to insert', 'authorbio'),
            "title" => __('Insert Event Shortcode', 'authorbio'),
            "select_error" => __('Please select a Form', 'authorbio'),
            "insert_text" => __('Insert Shortcode', 'authorbio'),
            "events" => $this->getAllEventsForMce(),
        ));

        // Setup filters
        add_filter('mce_external_plugins', array(&$this, 'addTinymcePlugin'));
        add_filter('mce_buttons', array(&$this, 'addTinymceToolbarButton'));
    }

    public function addTinymcePlugin($plugin_array)
    {
        $plugin_array['auth_bio_mce_job_button'] = AUTHORBIO_URL . 'dist/js/tinymce.js';
        return $plugin_array;
    }

    public function addTinymceToolbarButton($buttons)
    {
        array_push($buttons, '|', 'auth_bio_mce_job_button');
        return $buttons;
    }

    private function getAllEventsForMce()
    {
        $user_id = get_current_user_id();
            $formatted[] = array(
                'text' => 'Add author shortcode',
                'value' => $user_id
            );

        return $formatted;
    }
}
