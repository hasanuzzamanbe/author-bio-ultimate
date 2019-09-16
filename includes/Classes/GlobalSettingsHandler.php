<?php

namespace AuthorBio\Classes;
if (!defined('ABSPATH')) {
    exit;
}

class GlobalSettingsHandler
{
    public function registerHooks()
    {
        add_action('wp_ajax_author_bio_global_settings_handler', array($this, 'handleEndpoints'));
        add_filter( 'user_contactmethods', array($this, 'userContactMethods') );
    }

    public function handleEndpoints()
    {
        $routes = array(
            'author_bio_upload_image'        => 'handleFileUpload'
        );
        $route = sanitize_text_field($_REQUEST['route']);

        if (isset($routes[$route])) {

            do_action('authorbio/doing_ajax_global_'.$route);
            $this->{$routes[$route]}();
            return;
        }
    }

    protected function handleFileUpload()
    {
        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }
        $uploadedfile = $_FILES['file'];

        $acceptedFilles = array(
            'image/png',
            'image/jpeg'
        );

        if (!in_array($uploadedfile['type'], $acceptedFilles)) {
            wp_send_json(__('Please upload only jpg/png format files', 'authorbio'), 423);
        }

        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
        if ($movefile && !isset($movefile['error'])) {
            wp_send_json_success(array(
                'file' => $movefile
            ), 200);
        } else {
            wp_send_json(__('Something is wrong when uploading the file', 'authorbio'), 423);
        }
    }

    public function userContactMethods($methods)
    {
            $methods['designation'] = __( 'Designation', 'authorbio' );
            $methods['twitter'] = __( 'Twitter', 'authorbio' );
            $methods['facebook'] = __( 'Facebook', 'authorbio' );
            $methods['linkedin'] = __( 'Linkedin', 'authorbio' );
            $methods['instagram'] = __( 'Inatagram', 'authorbio' );
            return $methods;
    }

}
