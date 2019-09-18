<?php


namespace AuthorBio\Classes;
if (!defined('ABSPATH')) {
    exit;
}

class AdminAjaxHandler
{

    public function registerEndpoints()
    {
        add_action('wp_ajax_author_bio_admin_ajax', array($this, 'handleEndPoint'));
    }

    public function handleEndPoint()
    {
        $route = sanitize_text_field($_REQUEST['route']);

        $validRoutes = array(
            'add_bio' => 'addBio',
            'get_bio' => 'getBio',
            'update_settings' => 'updateSettings',
            'get_settings' => 'getSettings',

        );
        if (isset($validRoutes[$route])) {
            do_action('authorbio/doing_ajax_events_' . $route);
            return $this->{$validRoutes[$route]}();
        }

    }

    protected function addBio()
    {
        $data = wp_unslash($_REQUEST['data']);
        $socialsVal = array(
            'facebook' => sanitize_text_field($_REQUEST['socials']['facebook']),
            'twitter' => sanitize_text_field($_REQUEST['socials']['twitter']),
            'linkedin' => sanitize_text_field($_REQUEST['socials']['linkedin']),
            'instagram' => sanitize_text_field($_REQUEST['socials']['instagram'])
        );
        $author_bio = wp_unslash($data['bio']);
        $authorId = get_current_user_id();

        update_post_meta($authorId, 'author_bio_editorbio', $author_bio);
        update_post_meta($authorId, 'author_bio_social_option', $socialsVal);
        update_post_meta($authorId, 'author_bio_image_from_option', sanitize_text_field($_REQUEST['imageFrom']));


        global $wpdb;
        $table_name = $wpdb->prefix . 'author_bio';
        if ($data['authorId'] ) {
            $wpdb->update(
                $table_name,
                array(
                    "author_id" => $authorId,
                    "author_name" => sanitize_text_field($data['name']),
                    "author_email" => sanitize_email($data['email']),
                    "author_fb" => esc_url_raw($data['facebook']),
                    "author_tw" => esc_url_raw($data['twitter']),
                    "author_ln" => esc_url_raw($data['linkedin']),
                    "author_ins" => esc_url_raw($data['instagram']),
                    "author_img" => sanitize_text_field($data['profile']['image']),
                    "author_gravatar" => esc_url_raw($data['profile']['gravatar']),
                    "author_designation" => sanitize_text_field($data['designation']),
                    "useBioFrom" => sanitize_text_field($data['useBioFrom'])
                ),
                array('author_id' => $authorId)
            );
        } else {
            $wpdb->insert(
                $table_name,
                array(
                    "author_id" => $authorId,
                    "author_name" => sanitize_text_field($data['name']),
                    "author_email" => sanitize_email($data['email']),
                    "author_fb" => esc_url_raw($data['facebook']),
                    "author_tw" => esc_url_raw($data['twitter']),
                    "author_ln" => esc_url_raw($data['linkedin']),
                    "author_ins" => esc_url_raw($data['instagram']),
                    "author_img" => sanitize_text_field($data['profile']['image']),
                    "author_gravatar" => esc_url_raw($data['profile']['gravatar']),
                    "author_designation" => sanitize_text_field($data['designation']),
                    "useBioFrom" => sanitize_text_field($data['useBioFrom'])
                )
            );
            wp_send_json_success(array(
                'response' => 'success',
            ), 200);
        }

    }

    public function getBio()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'author_bio';
        $authorId = get_current_user_id();
        $data = $wpdb->get_row("SELECT * FROM $table_name WHERE author_id = $authorId");

        $bioFromeditor = get_post_meta($authorId, 'author_bio_editorbio', true);
        $socials = get_post_meta($authorId, 'author_bio_social_option', true);
        if ($socials === '') {
            $socials = [
                'facebook' => 'true',
                'twitter' => 'true',
                'linkedin' => 'true',
                'instagram' => 'true',
            ];
        };
        $imageFrom = get_post_meta($authorId, 'author_bio_image_from_option', true);
        if ($imageFrom === '') {
            $imageFrom = 'gravatar';
        };
        wp_send_json_success(array(
            'data' => $data,
            'socials' => $socials,
            'imageFrom' => $imageFrom,
            'bio' => $bioFromeditor
        ), 200);

    }

    public static function getUserInfos($authorId)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'author_bio';
        $data = $wpdb->get_row("SELECT * FROM $table_name WHERE author_id = $authorId");
        $socials = get_post_meta(absint($authorId), 'author_bio_social_option', true);
        $imageFrom = get_post_meta(absint($authorId), 'author_bio_image_from_option', true);
        $bioFromeditor = get_post_meta(absint($authorId), 'author_bio_editorbio', true);

        return array(
            'data' => $data,
            'socials' => $socials,
            'imageFrom' => $imageFrom,
            'bio' => $bioFromeditor
        );
    }

    public static function updateSettings()
    {

        $settingsData = wp_unslash($_REQUEST['data']);
        $data = array(
            "useTemp" => sanitize_text_field($settingsData['useTemp']),
            "postCount" => sanitize_text_field($settingsData['postCount']),
            "excludes" => sanitize_text_field($settingsData['excludes']),
            "excludesArray" => $settingsData['excludesArray'],
            "recentType" => sanitize_text_field($settingsData['recentType']),
            "recentPost" => sanitize_text_field($settingsData['recentPost'])
        );
        update_option('author_bio_template', $data, false);

    }

    public static function getSettings()
    {
        $settings = get_option('author_bio_template');

        if (!$settings || $settings['useTemp'] === '') {
            $settings = array(
                "useTemp" => "template2",
                "recentPost" => "enabled",
                "postCount" => "3",
                "excludes" => '',
                "excludesArray" => [],
                "recentType" => 'titleonly'
            );
        }


        wp_send_json_success(array(
            'settings' => $settings,
        ), 200);
    }

    public static function getSettingsFrontend()
    {

        $template = get_option('author_bio_template');

        if (!$template || $template === '' || $template === null) {
            $template = array(
                "useTemp" => "template2",
                "recentPost" => "enabled",
                "postCount" => "3",
                "excludes" => '',
                "excludesArray" => [],
                "recentType" => 'titleonly'
            );

        }
        return $template;
    }

}
