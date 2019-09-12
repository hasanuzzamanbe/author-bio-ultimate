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
        $template = get_post_meta($author->ID, 'author_bio_template', true);
        if($template === '' || null){
            $template = 'template2';
        }

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
                <?php if($template !== 'template1' && $template !== 'template3'){ ?>
                    <div class="author_bio_socials socials_template2">

                    <?php if ($socials['facebook'] === 'true') { ?>
                        <a href="<?php echo $data->author_fb; ?>" target="_blank">
                            <i class="authbio-facebook-circled"></i>
                        </a>

                    <?php }
                    if ($socials['twitter'] === 'true') { ?>
                        <a href="<?php echo $data->author_tw; ?> " target="_blank">
                            <i class="authbio-twitter-circled"></i>
                        </a>
                    <?php }
                    if ($socials['linkedin'] === 'true') { ?>

                        <a href="<?php echo $data->author_ln; ?> " target="_blank">
                            <i class="authbio-linkedin-circled"></i>
                        </a>

                    <?php }
                    if ($socials['instagram'] === 'true') { ?>
                        <a class="insta" href="<?php echo $data->author_ins; ?> " target="_blank">
                            <i class="authbio-instagrem"></i>
                        </a>
                    <?php } ?>

                </div>
                 <?php } ?>
            </div>

            <div class="author_bio_content">
            <div class="author_bio_content_inner">
                <h2 class="author_name">
                    <?php echo($data->author_name); ?>
                </h2>
                <?php if($template === 'template3'){ ?>
                    <div class="author_bio_socials">

                        <?php if ($socials['facebook'] === 'true') { ?>
                            <a href="<?php echo $data->author_fb; ?>" target="_blank">
                                <i class="authbio-facebook-circled"></i>
                            </a>

                        <?php }
                        if ($socials['twitter'] === 'true') { ?>
                            <a href="<?php echo $data->author_tw; ?> " target="_blank">
                                <i class="authbio-twitter-circled"></i>
                            </a>
                        <?php }
                        if ($socials['linkedin'] === 'true') { ?>

                            <a href="<?php echo $data->author_ln; ?> " target="_blank">
                                <i class="authbio-linkedin-circled"></i>
                            </a>

                        <?php }
                        if ($socials['instagram'] === 'true') { ?>
                            <a href="<?php echo $data->author_ins; ?> " target="_blank">
                                <i class="authbio-instagrem"></i>
                            </a>
                        <?php } ?>

                    </div>
                <?php } ?>
            </div>
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
                <?php if($template === 'template1'){ ?>
                    <div class="author_bio_socials_template1">
                    <div class="author_bio_socials socials_template1">
                        <?php if ($socials['facebook'] === 'true') { ?>
                            <a href="<?php echo $data->author_fb; ?>" target="_blank">
                                <i class="authbio-facebook-circled"></i>
                            </a>

                        <?php }
                        if ($socials['twitter'] === 'true') { ?>
                            <a href="<?php echo $data->author_tw; ?> " target="_blank">
                                <i class="authbio-twitter-circled"></i>
                            </a>
                        <?php }
                        if ($socials['linkedin'] === 'true') { ?>

                            <a href="<?php echo $data->author_ln; ?> " target="_blank">
                                <i class="authbio-linkedin-circled"></i>
                            </a>

                        <?php }
                        if ($socials['instagram'] === 'true') { ?>
                            <a class="insta" href="<?php echo $data->author_ins; ?> " target="_blank">
                                <i class="authbio-instagrem"></i>
                            </a>
                        <?php } ?>

                    </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <?php
        $bio_content = ob_get_clean();
        $recentPosts ='';
        if(true){
            $recentPosts .=   $this->getRecent($post, $data->author_name);
        }
        $tab = "<div class='auth_bio_tab_main'>";
        $tab .= "<button class='tablinks' data-tab_name='auth_bio_tab'>Bio</button>";
        $tab .= "<button class='tablinks' data-tab_name='auth_recent_tab'>Recent post</button>";
        $tab .= "</div>";
        $tab .= "<div style='display: block;' id='auth_bio_tab' class='auth_bio_tabcontent'>";
        $tab .= $bio_content;
        $tab .= "</div>";
        $tab .= "<div id='auth_recent_tab' class='auth_bio_tabcontent'>";
        $tab .= $recentPosts;
        $tab .= "</div>";
        return $content . $tab;
    }

    private function word_count($string, $limit)
    {
        $words = explode(' ', $string);
        return implode(' ', array_slice($words, 0, $limit));
    }

    public function getRecent($post, $authorName){
        $authorId=$post->post_author;
        $html =   '<p class="author_bio_more_post">More Posts By '.$authorName.'</p>';

        $html .= "<div class='author_bio_recent_main'>";
        $query = array('author' => $authorId, 'showposts' => '3', 'post_type'=> 'post', 'post__not_in' => array( $post->ID ),'post_status' => 'publish');
        $recent_posts = get_posts($query);

        foreach ($recent_posts as $recent) {

            $html .= "<div class='author_bio_recent_inner_post'>";
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($recent->ID), 'single-post-thumbnail');
            $html .=  '<div class="auth_post_recent_img" style="background-image: url('.$image[0].');"></div>';
            $html .= '<div class="auth_post_recent_title">';
            $title = $this->word_count($recent->post_title, 8);
            $html .="<p>$title</p>" ;
            $html .= '</div>';
            $html .= '<a href="' . get_permalink($recent->ID) . '" title="Look ' . esc_attr($recent->post_title) . '" >See More</a> </div>';

        }
        $html .= "</div>";


//        $recents .= $this->word_count($recent["post_content"], 18) . '...';
//        $recents .= '<br><a href="' . get_permalink($recent["ID"]) . '" title="Look ' . esc_attr($recent["post_title"]) . '" >Details</a> </div>';
//        dd($recent_posts);

        return $html;
    }

    public function addAssets()
    {
        wp_enqueue_style('author_bio_public', AUTHORBIO_URL . 'dist/admin/css/author-bio-public.css', array(), AUTHORBIO_VERSION);
        wp_enqueue_script(
            'author_bio_frontend_js',
            AUTHORBIO_URL . 'dist/admin/js/author-bio-frontent.js',
            array( 'jquery' ),
            AUTHORBIO_VERSION,
            true
        );
    }


}
