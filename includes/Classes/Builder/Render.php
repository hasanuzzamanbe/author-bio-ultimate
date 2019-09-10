<?php

namespace AuthorBio\Classes\Builder;

if (!defined('ABSPATH')) {
    exit;
}


class Render
{
    public function Render()
    {
        add_filter ('the_content', 'author_bio_next_to_post');
    }

    public function author_bio_next_to_post ( $content ) {


        global $post;

        $author  = get_user_by( 'id', $post->post_author );
        $bio = get_user_meta( $author->ID, 'description', true );
//        $twitter = get_user_meta( $author->ID, 'twitter', true );
//        $facebook = get_user_meta( $author->ID, 'facebook', true );
//        $linkedin = get_user_meta( $author->ID, 'linkedin', true );
        ob_start();
        ?>

        <div class="author_bio_main_wrap">
            <div class="name_bio_avatar">
                <div class="avater-image">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
                </div>
                <div class="author_bio_content">
                    <div class="auth_name_sh">
                        <?php echo the_author_posts_link(); ?>
                    </div>

                    <div class="auth_bio_sh"> <?php echo wpautop( wp_kses_post( $bio ) ); ?>
                    </div>
                </div>
            </div>
            <!--           -->
        </div>

        <?php
        $bio_content = ob_get_clean();
        return $content . $bio_content;
    }
}
