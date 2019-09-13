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


        $author = get_user_by('id', $post->post_author);

        $template = AdminAjaxHandler::getSettingsFrontend();

        $hasExclude = in_array($post->ID, $template['excludesArray']);
        if ($hasExclude) {
            return $content;
        };
        $info = AdminAjaxHandler::getUserInfos($post->post_author);

        $data = $info['data'];

        $socials = $info['socials'];

        $image = "<img style='width:128px;' src='$data->author_img'>";
        $apost = get_author_posts_url(get_the_author_meta('ID'));
        $user_info = get_userdata($author->ID);

        $twitter = get_user_meta($author->ID, 'twitter', true);
        $facebook = get_user_meta($author->ID, 'facebook', true);
        $linkedin = get_user_meta($author->ID, 'linkedin', true);
        $instagram = get_user_meta($author->ID, 'instagram', true);
        $authFullname =  '';
        if ($data !== null) {
            $authFullname = $data->author_name;
        } else {
            $authFullname = $user_info->display_name;
        }

        $bio = get_user_meta($author->ID, 'description', true);
//
//        if ($template['useTemp'] === '' || null) {
//            $template['useTemp'] = 'template2';
//        }

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
                <?php if ($template['useTemp'] !== 'template1' && $template['useTemp'] !== 'template3') { ?>
                    <div class="author_bio_socials socials_template2">
                        <?php if ($data->author_ln !== null && $socials['facebook'] === 'true') {
                            ?>  <a href="<?php echo $data->author_fb; ?> " target="_blank">
                                <i class="authbio-facebook"></i>
                            </a>
                            <?php
                        } elseif ($facebook !== '') {
                            ?>  <a  href="<?php echo $facebook; ?> " target="_blank">
                                <i class="authbio-facebook"></i>
                            </a>
                        <?php }
                        if ($data->author_ln && $socials['twitter'] === 'true') {
                            ?>  <a href="<?php echo $data->author_tw; ?> " target="_blank">
                                <i class="authbio-twitter"></i>
                            </a>
                            <?php
                        } elseif ($twitter !== '') {
                            ?>  <a  href="<?php echo $twitter; ?> " target="_blank">
                                <i class="authbio-twitter"></i>
                            </a>
                        <?php }
                            if ($data->author_ln && $socials['linkedin'] === 'true') {
                                ?>  <a href="<?php echo $data->author_ln; ?> " target="_blank">
                                      <i class="authbio-linkedin"></i>
                                    </a>
                                <?php
                            } elseif ($linkedin !== '') {
                                ?>  <a  href="<?php echo $linkedin; ?> " target="_blank">
                                    <i class="authbio-linkedin"></i>
                                    </a>
                        <?php }
                            if ($data->author_ins && $socials['instagram'] === 'true') {
                                ?>  <a class="insta" href="<?php echo $data->author_ins; ?> " target="_blank">
                                       <i class="authbio-instagram"></i>
                                    </a>
                                <?php
                            } elseif ($instagram !== '') {
                                ?>  <a class="insta" href="<?php echo $instagram; ?> " target="_blank">
                                       <i class="authbio-instagram"></i>
                                    </a>
                                <?php
                            }
                        ?>

                    </div>
                <?php } ?>
            </div>

            <div class="author_bio_content">
                <div class="author_bio_content_inner">

                    <h2 class="author_name">
                        <?php
                            echo $authFullname;
                        ?>
                    </h2>

                    <?php if ($template['useTemp'] === 'template3') { ?>
                        <div class="author_bio_socials socials_template3">
                            <?php if ($data->author_ln !== null && $socials['facebook'] === 'true') {
                                ?>  <a href="<?php echo $data->author_fb; ?> " target="_blank">
                                    <i class="authbio-facebook"></i>
                                </a>
                                <?php
                            } elseif ($facebook !== '') {
                                ?>  <a  href="<?php echo $facebook; ?> " target="_blank">
                                    <i class="authbio-facebook"></i>
                                </a>
                            <?php }
                            if ($data->author_ln && $socials['twitter'] === 'true') {
                                ?>  <a href="<?php echo $data->author_tw; ?> " target="_blank">
                                    <i class="authbio-twitter"></i>
                                </a>
                                <?php
                            } elseif ($twitter !== '') {
                                ?>  <a  href="<?php echo $twitter; ?> " target="_blank">
                                    <i class="authbio-twitter"></i>
                                </a>
                            <?php }
                            if ($data->author_ln && $socials['linkedin'] === 'true') {
                                ?>  <a href="<?php echo $data->author_ln; ?> " target="_blank">
                                    <i class="authbio-linkedin"></i>
                                </a>
                                <?php
                            } elseif ($linkedin !== '') {
                                ?>  <a  href="<?php echo $linkedin; ?> " target="_blank">
                                    <i class="authbio-linkedin"></i>
                                </a>
                            <?php }
                            if ($data->author_ins && $socials['instagram'] === 'true') {
                                ?>  <a class="insta" href="<?php echo $data->author_ins; ?> " target="_blank">
                                    <i class="authbio-instagram"></i>
                                </a>
                                <?php
                            } elseif ($instagram !== '') {
                                ?>  <a class="insta" href="<?php echo $instagram; ?> " target="_blank">
                                    <i class="authbio-instagram"></i>
                                </a>
                                <?php
                            }
                            ?>

                        </div>
                    <?php } ?>
                </div>
                <?php
                if ($data->author_email !== '') {
                    ?>
                    <div class="author_email">
                        <i class="authbio-mail"></i>
                        <a href="mailto:<?php echo($data->author_email); ?>">
                            <?php
                            if ($data->author_email !== '' && $data->author_email !== null) {
                                echo($data->author_email);
                            } else {
                                echo $user_info->user_email;
                            }
                            ?>
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
                <?php if ($template['useTemp'] === 'template1') { ?>
                    <div class="author_bio_socials socials_template1">
                        <?php if ($data->author_ln !== null && $socials['facebook'] === 'true') {
                            ?>  <a href="<?php echo $data->author_fb; ?> " target="_blank">
                                <i class="authbio-facebook"></i>
                            </a>
                            <?php
                        } elseif ($facebook !== '') {
                            ?>  <a  href="<?php echo $facebook; ?> " target="_blank">
                                <i class="authbio-facebook"></i>
                            </a>
                        <?php }
                        if ($data->author_ln && $socials['twitter'] === 'true') {
                            ?>  <a href="<?php echo $data->author_tw; ?> " target="_blank">
                                <i class="authbio-twitter"></i>
                            </a>
                            <?php
                        } elseif ($twitter !== '') {
                            ?>  <a  href="<?php echo $twitter; ?> " target="_blank">
                                <i class="authbio-twitter"></i>
                            </a>
                        <?php }
                        if ($data->author_ln && $socials['linkedin'] === 'true') {
                            ?>  <a href="<?php echo $data->author_ln; ?> " target="_blank">
                                <i class="authbio-linkedin"></i>
                            </a>
                            <?php
                        } elseif ($linkedin !== '') {
                            ?>  <a  href="<?php echo $linkedin; ?> " target="_blank">
                                <i class="authbio-linkedin"></i>
                            </a>
                        <?php }
                        if ($data->author_ins && $socials['instagram'] === 'true') {
                            ?>  <a class="insta" href="<?php echo $data->author_ins; ?> " target="_blank">
                                <i class="authbio-instagram"></i>
                            </a>
                            <?php
                        } elseif ($instagram !== '') {
                            ?>  <a class="insta" href="<?php echo $instagram; ?> " target="_blank">
                                <i class="authbio-instagram"></i>
                            </a>
                            <?php
                        }
                        ?>

                    </div>
                <?php } ?>
            </div>
        </div>

        <?php
        $bio_content = ob_get_clean();

        $recentPosts = '';

        if ($template['recentPost'] === 'enabled') {
            $postCount = $template['postCount'];
            $recentPosts .= $this->getRecent($post,$authFullname, $postCount);
        } else {
            return $content . $bio_content;
        }
        $tab = "<div class='auth_bio_tab_main'>";
        $tab .= "<button id='auth_bio_left_btn' class='authbiotablinks active' data-tab_name='auth_bio_tab'>Bio</button>";
        $tab .= "<button id='auth_bio_right_btn' class='authbiotablinks' data-tab_name='auth_recent_tab'>Latest posts</button>";
        $tab .= "</div>";
        $tab .= "<div style='display: block;' id='auth_bio_tab' class='auth_bio_tabcontent'>";
        $tab .= $bio_content;
        $tab .= "</div>";
        $tab .= "<div id='auth_recent_tab' class='auth_bio_tabcontent'>";
        $tab .= $recentPosts;
        $tab .= "<strong><a href='$apost'>See " . $authFullname . "'s all post >></a></strong>";
        $tab .= "</div>";

        return $content . $tab;
    }

    private function word_count($string, $limit)
    {
        $words = explode(' ', $string);
        return implode(' ', array_slice($words, 0, $limit));
    }

    public function getRecent($post, $authorName, $postCount)
    {
        if ($postCount === null || $postCount === '') {
            $postCount = 3;
        }
        $authorId = $post->post_author;
        $query = array('author' => $authorId, 'showposts' => $postCount, 'post_type' => 'post', 'post__not_in' => array($post->ID), 'post_status' => 'publish');
        $recent_posts = get_posts($query);
        $html = '';
        if ($recent_posts) {
            $html .= '<p class="author_bio_more_post">More Posts By ' . $authorName . '</p>';
        } else {
            $html .= '<p class="author_bio_more_post">No more posts by' . $authorName . '</p>';
        }


        $html .= "<div class='author_bio_recent_main'>";

        foreach ($recent_posts as $recent) {

            $html .= "<div class='author_bio_recent_inner_post'>";
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($recent->ID), 'single-post-thumbnail');
            $html .= '<div class="auth_post_recent_img" style="background-image: url(' . $image[0] . ');"></div>';
            $html .= '<div class="auth_post_recent_title">';
            $title = $this->word_count($recent->post_title, 8);
            $html .= '<a href="' . get_permalink($recent->ID) . '" title="Look ' . esc_attr($recent->post_title) . '" >' . $title . '</a> </div>';
            $html .= '</div>';

        }
        $html .= "</div>";
        return $html;
    }

    public function addAssets()
    {
        wp_enqueue_style('author_bio_public', AUTHORBIO_URL . 'dist/admin/css/author-bio-public.css', array(), AUTHORBIO_VERSION);
        wp_enqueue_script(
            'author_bio_frontend_js',
            AUTHORBIO_URL . 'dist/admin/js/author-bio-frontent.js',
            array('jquery'),
            AUTHORBIO_VERSION,
            true
        );
    }


}
