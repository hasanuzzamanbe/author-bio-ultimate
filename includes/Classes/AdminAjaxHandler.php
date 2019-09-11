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
        $imageFrom = $_REQUEST[imageFrom];

        $socialsVal = wp_unslash(array(
            'facebook' => $socials[facebook],
            'twitter' => $socials[twitter],
            'linkedin' => $socials[linkedin],
            'instagram' => $socials[instagram]
        ));
        $author_bio = wp_unslash($data[bio]);
        $authorId = get_current_user_id();


        update_post_meta($authorId, 'author_bio_editorbio', $author_bio);
        update_post_meta($authorId, 'author_bio_social_option', $socialsVal);
        update_post_meta($authorId, 'author_bio_image_from_option', $imageFrom);



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
                    "author_ins" => $data[instagram],
                    "author_img" => $data[profile][image],
                    "author_gravatar" => $data[profile][gravatar],
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
                    "author_ins" => $data[instagram],
                    "author_img" => $data[profile][img],
                    "author_gravatar" => $data[profile][gravatar],
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

    public function getBio()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'author_bio';
        $authorId = get_current_user_id();
        $data = $wpdb->get_row("SELECT * FROM $table_name WHERE author_id = $authorId");

        $bioFromeditor = get_post_meta($authorId, 'author_bio_editorbio', true);
        $socials = get_post_meta($authorId, 'author_bio_social_option', true);
        if($socials === '') {
            $socials = [
                'facebook' => true,
                'twitter' => true,
                'linkedin' => true,
                'instagram' => true,
                ];
        };
        $imageFrom = get_post_meta($authorId, 'author_bio_image_from_option', true);
        if($imageFrom === '') {
            $imageFrom = 'gravatar';
        };
        wp_send_json_success(array(
            'data'        => $data,
            'socials'     => $socials,
            'imageFrom'   => $imageFrom,
            'bio'         => $bioFromeditor
        ), 200);

    }

    public static function getUserInfos($authorId)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'author_bio';
        $data = $wpdb->get_row("SELECT * FROM $table_name WHERE author_id = $authorId");
        $socials = get_post_meta($authorId, 'author_bio_social_option', true);
        $imageFrom = get_post_meta($authorId, 'author_bio_image_from_option', true);
        $bioFromeditor = get_post_meta($authorId, 'author_bio_editorbio', true);
        return array(
            'data'        => $data,
            'socials'     => $socials,
            'imageFrom'   => $imageFrom,
            'bio'         => $bioFromeditor
        );
    }

}
