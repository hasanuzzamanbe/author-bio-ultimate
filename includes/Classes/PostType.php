<?php
/**
 * Created by PhpStorm.
 * User: ah1
 * Date: 2019-06-16
 * Time: 11:23
 */

namespace AuthorBio\Classes;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register and initialize custom post type for authorbio
 * @since 1.0.0
 */

class PostType {
    public function __construct()
    {
        add_action('init', array( $this , 'register'));
    }

    public function register()
    {
        $args = array(
            'capability_type' => 'post',
            'public'          => false,
            'show_ui'         => false,
        );
        register_post_type( 'authorbio', $args );
    }

}
