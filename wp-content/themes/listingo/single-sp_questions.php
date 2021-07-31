<?php
/**
 *
 * The template used for displaying default article post style
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $post, $current_user;
do_action('sp_set_question_views', $post->ID, 'question_views');
get_header();

$listingo_sidebar = 'full';
$section_width = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
if (function_exists('fw_ext_sidebars_get_current_position')) {
    $current_position = fw_ext_sidebars_get_current_position();
    if ($current_position != 'full' && ( $current_position == 'left' || $current_position == 'right' )) {
        $listingo_sidebar = $current_position;
        $section_width = 'col-xs-12 col-sm-8 col-md-8 col-lg-8';
    }
}

if (isset($listingo_sidebar) && $listingo_sidebar === 'right') {
    $aside_class = 'pull-right';
    $content_class = 'pull-left';
} else {
    $aside_class = 'pull-left';
    $content_class = 'pull-right';
}

//Authentication page
$auth_page	= listingo_get_login_registration_page_uri();
?>
<div class="container">
    <div class="row">
        <div id="tg-twocolumns" class="tg-twocolumns">
            <div class="<?php echo esc_attr($section_width); ?> <?php echo sanitize_html_class($content_class); ?>">
                <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        $question_by = get_post_meta($post->ID, 'question_by', true);
                        $question_to = get_post_meta($post->ID, 'question_to', true);
                        $category = get_post_meta($post->ID, 'question_cat', true);

                        $category_icon = '';
                        $category_color = '';
                        if (function_exists('fw_get_db_post_option') && !empty($category)) {
                            $categoy_bg_img = fw_get_db_post_option($category, 'category_image', true);
                            $category_icon = fw_get_db_post_option($category, 'category_icon', true);
                            $category_color = fw_get_db_post_option($category, 'category_color', true);
                        }

                        global $post;
                        ?>
                        <div id="tg-content" class="tg-content tg-companyfeaturebox">
                            <div class="tg-question">
                                <div class="tg-questioncontent">
                                    <div class="tg-answerholder spq-v2">
                                        <?php
                                        if (isset($category_icon['type']) && $category_icon['type'] === 'icon-font') {
                                            do_action('enqueue_unyson_icon_css');
                                            if (!empty($category_icon['icon-class'])) {
                                                ?>
                                                <figure class="tg-docimg"><span class="<?php echo esc_attr($category_icon['icon-class']); ?> tg-categoryicon" style="background: <?php echo esc_attr($category_color); ?>;"></span></figure>
                                                <?php
                                            }
                                        } else if (isset($category_icon['type']) && $category_icon['type'] === 'custom-upload') {
                                            if (!empty($category_icon['url'])) {
                                                ?>
                                                <figure class="tg-docimg"><em><img src="<?php echo esc_url($category_icon['url']); ?>" alt="<?php esc_html_e('category', 'listingo'); ?>"></em></figure>
                                                <?php
                                            }
                                        }
                                        ?>

                                        <h4><a href="<?php echo esc_url(get_permalink()); ?>"> <?php echo esc_attr(get_the_title()); ?> </a></h4>
                                        <div class="tg-description">
                                            <?php the_content(); ?>
                                        </div>
                                        <div class="tg-questionbottom">
                                            <?php if (intval($question_by) !== intval($current_user->ID)) { ?>
                                                <a class="tg-btn" data-toggle="collapse" data-target="#tg-add-answer" href="javascript:;">
                                                    <i class="fa fa-plus"></i><?php esc_html_e('Add Your Answer', 'listingo'); ?>
                                                </a>
                                            <?php } ?>
                                            <?php
												if (!function_exists('fw_ext_get_total_votes_and_answers_html')) {
													fw_ext_get_total_votes_and_answers_html($post->ID);
												}
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if (function_exists('fw_ext_get_views_and_time_html')) {?>
                                <div class="tg-matadatahelpfull">
                                    <?php fw_ext_get_views_and_time_html($post->ID); ?>
                                    <?php fw_ext_get_votes_html($post->ID, esc_html__('Is this helpful?', 'listingo')); ?>
                                </div>
                                <?php }?>
                            </div>
                            <div id="tg-add-answer" class="collapse tg-add-answer">
                                <?php
                                if (is_user_logged_in()) {
                                    if (intval($question_by) !== intval($current_user->ID)) {
                                        ?>
                                        <div class="tg-companyfeaturebox tg-addyouranswer">
                                            <div class="tg-companyfeaturetitle">
                                                <h3><?php esc_html_e('Add your answer', 'listingo'); ?></h3>
                                            </div>
                                            <form class="listingo_answer_form tg-formtheme tg-formaddquestion">
                                                <fieldset>
                                                    <div class="form-group">
                                                        <?php
															$content = '';
															$settings = array('media_buttons' => false,'editor_height'=> 300,'quicktags'=> false);
															wp_editor($content, 'answer_description', $settings);
                                                        ?>
                                                    </div>
                                                    <div class="tg-btns">
                									<?php wp_nonce_field('listingo_answers_nounce', 'listingo_answers_nounce'); ?>
                                                        <input type="hidden" name="question_id" value="<?php echo intval($post->ID); ?>">
                                                        <button type="button" class="tg-btn tg-btnaddanswer answer_save_btn"><?php esc_html_e('Submit Answer', 'listingo'); ?></button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    <?php }
                                } else {
                                    ?>
                                    <div class="login-to-add tg-haslayout">
                                        <a class="tg-btn" href="<?php echo esc_url($auth_page); ?>"><?php esc_html_e('Login to add your answer', 'listingo'); ?></a>
                                    </div>
                            <?php } ?>
                            </div>
                            <?php
                            if (function_exists('fw_get_db_settings_option') && fw_ext('questionsanswers')) {
                                do_action('render_answers_view');
                            }
                            ?>

                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <?php
            if (function_exists('fw_ext_sidebars_get_current_position')) {
                if ($current_position !== 'full') {
                    ?>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 <?php echo sanitize_html_class($aside_class); ?>">
                        <aside id="tg-sidebar" class="tg-sidebar">
                    <?php echo fw_ext_sidebars_show('blue'); ?>
                        </aside>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<?php
get_footer();
