<?php

namespace AuthorBio\Classes\Builder;
use AuthorBio\Classes\Models\Queries;
use AuthorBio\Classes\AdminAjaxHandler;

if (!defined('ABSPATH')) {
    exit;
}


class Render
{
    public function Render()
    {
        add_filter('the_content', array($this, 'author_bio_next_to_post'), 10, 2);
    }

    public function author_bio_next_to_post ( $content ) {

        global $post;
        $info = AdminAjaxHandler::getUserInfos($post->post_author);
        $data = $info['data'];
        $socials = $info['socials'];
        $image = "<img style='width:128px;' src='$data->author_img'>";
//        $socials['facebook'];


        $author  = get_user_by( 'id', $post->post_author );
        $bio = get_user_meta( $author->ID, 'description', true );
//        $twitter = get_user_meta( $author->ID, 'twitter', true );
//        $facebook = get_user_meta( $author->ID, 'facebook', true );
//        $linkedin = get_user_meta( $author->ID, 'linkedin', true );
        ob_start();
        ?>

        <div class="author_bio_main_wrap">
                <div class="avater-image">
                    <?php if($info['imageFrom'] === 'upload'){
                            echo $image;
                          }else{
                             echo get_avatar( get_the_author_meta( 'ID' ), 128 );
                          }
                    ?>
                </div>

                <div class="author_bio_content">

                    <div class="author_name">
                        <?php echo ($data->author_name); ?>
                    </div>

                    <div class="author_bio_desig">
                        <?php echo ($data->author_designation); ?>
                    </div>

                    <div class="author_bio_descr">
                        <?php
                            if($data->useBioFrom === 'newAddedBio'){
                                echo ($info['bio']);
                            }else {
                                echo wpautop( wp_kses_post( $bio ) );
                            }
                        ?>
                    </div>
                    <div class="author_bio_socials">

                    </div>

                </div>
        </div>

        <?php
        $bio_content = ob_get_clean();
        return $content . $bio_content;
    }


}
