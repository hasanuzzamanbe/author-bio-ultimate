<?php

namespace AuthorBio\Classes\Builder;

use AuthorBio\Classes\AdminAjaxHandler;
use AuthorBio\Classes\Models\Queries;

if (!defined('ABSPATH')) {
    exit;
}


class Render
{
    public function Render()
    {
        add_filter('the_content', array($this, 'author_bio_next_to_post'), 10, 2);
    }

    public function author_bio_next_to_post($content)
    {
        $this->addAssets();

        global $post;
        $info = AdminAjaxHandler::getUserInfos($post->post_author);
        $data = $info['data'];
        $socials = $info['socials'];
        $image = "<img style='width:128px;' src='$data->author_img'>";

        $author = get_user_by('id', $post->post_author);
        $bio = get_user_meta($author->ID, 'description', true);

        ob_start();
        ?>

        <div class="author_bio_main_wrap">
            <div class="author_bio_left_col">
                <div class="avater-image">
                    <?php if ($info['imageFrom'] === 'upload') {
                        echo $image;
                    } else {
                        echo get_avatar(get_the_author_meta('ID'), 256);
                    }
                    ?>
                </div>
                <div class="author_bio_socials">

                <?php if ($socials['facebook'] === 'true') { ?>
                    <a href="<?php echo $data->author_fb; ?>" target="_blank">
                        <i class="authbio-facebook-circled"></i>
                    </a>

                    <?php } if ($socials['twitter'] === 'true') { ?>
                    <a href="<?php echo $data->author_tw; ?> " target="_blank">
                        <i class="authbio-twitter-circled"></i>
                    </a>
                     <?php } if ($socials['linkedin'] === 'true') { ?>

                     <a href="<?php echo $data->author_ln; ?> " target="_blank">
                        <i class="authbio-linkedin-circled"></i>
                    </a>

                    <?php } if ($socials['instagram'] === 'true') { ?>
                        <a href="<?php echo $data->author_ins; ?> " target="_blank">
                            <i class="authbio-instagrem"></i>
                        </a>
                    <?php } ?>

            </div>
            </div>

            <div class="author_bio_content">
                <h1 class="author_name">
                    <?php echo($data->author_name); ?>
                </h1>
                <?php
                if ($data->author_email !== '') {
                    ?>
                    <div class="author_email">
                        <i class="authbio-mail"></i>
                        <a href="mailto:<?php echo($data->author_email); ?>">
                            <?php echo($data->author_email); ?>
                        </a>
                    </div>
                    <?php
                }
                ?>


                <p class="author_bio_desig">
                    <?php echo($data->author_designation); ?>
                </p>

                <div class="author_bio_descr">
                    <?php
                    if ($data->useBioFrom === 'newAddedBio') {
                        echo($info['bio']);
                    } else {
                        echo wpautop(wp_kses_post($bio));
                    }
                    ?>
                </div>

            </div>
        </div>

        <?php
        $bio_content = ob_get_clean();
        return $content . $bio_content;
    }

    public function addAssets()
    {
        wp_enqueue_style('author_bio_public', AUTHORBIO_URL . 'dist/admin/css/author-bio-public.css', array(), AUTHORBIO_VERSION);
    }


}
