<?php
/**
 * Created by PhpStorm.
 * User: ah1
 * Date: 2019-09-09
 * Time: 16:03
 */

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

        );
        if (isset($validRoutes[$route])) {
            do_action('authorbio/doing_ajax_events_' . $route);
            return $this->{$validRoutes[$route]}();
        }

    }

    protected function addBio()
    {
        $data = $_REQUEST[data];
        $socials = $_REQUEST[socials];

        $socialsVal = array(
            'facebook' => $socials[facebook],
            'twitter' => $socials[twitter],
            'linkedin' => $socials[linkedin],
        );

        update_option( 'author_bio_social_option', $socialsVal, false );

      $authorId = get_current_user_id();

        global $wpdb;
        $table_name = $wpdb->prefix . 'author_bio';
        if ($data[authorId] !== '') {
            $wpdb->update(
                $table_name,
                array(
                    "author_id" => $authorId,
                    "author_name" => $data[name],
                    "author_email" => $data[email],
                    "author_fb" => $data[facebook],
                    "author_tw" => $data[twitter],
                    "author_ln" => $data[linkedin],
                    "author_img" => $data[profile][image],
                    "author_gravatar" => $data[profile][gravatar],
                    "author_bio" => $data[bio],
                    "author_designation" => $data[designation],
                    "useBioFrom" => $data[useBioFrom],
                ),
                array('author_id' => $authorId)
            );
        } else {
            $wpdb->insert(
                $table_name,
                array(
                    "author_id" => $authorId,
                    "author_name" => $data[name],
                    "author_email" => $data[email],
                    "author_fb" => $data[facebook],
                    "author_tw" => $data[twitter],
                    "author_ln" => $data[linkedin],
                    "author_img" => $data[profile][img],
                    "author_gravatar" => $data[profile][gravatar],
                    "author_bio" => $data[bio],
                    "author_designation" => $data[designation],
                    "useBioFrom" => $data[useBioFrom],
                ),
                array(
                    '%s',
                    '%d'
                )
            );

            wp_send_json_success(array(
                'response' => 'success',
            ), 200);
        }

    }

    protected function getBio()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'author_bio';
        $authorId = get_current_user_id();
        $data = $wpdb->get_row("SELECT * FROM $table_name WHERE author_id = $authorId");
        $socials = get_option('author_bio_social_option', true);

        wp_send_json_success(array(
            'data'        => $data,
            'socials'        => $socials
        ), 200);

    }

}
