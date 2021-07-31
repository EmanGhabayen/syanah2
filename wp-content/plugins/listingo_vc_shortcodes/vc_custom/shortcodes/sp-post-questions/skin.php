<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Post_Questions')) {

    class SC_VC_Skin_Listingo_Post_Questions extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_post_questions", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "sec_title" => '',
                "recent" => '',
				"vc_number" => '18',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_post_questions', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            global $paged;
            $pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
            $pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
            //paged works on single pages, page - works on homepage
            $paged = max($pg_page, $pg_paged);

            $order = 'DESC';
            $orderby = 'ID';
            $show_posts = !empty( $vc_number ) ? $vc_number : get_option('posts_per_page');

            //Main Query 
            $query_args = array(
                'posts_per_page' => $show_posts,
                'post_type' => 'sp_questions',
                'paged' => $paged,
                'order' => $order,
                'orderby' => $orderby,
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1);

            $query = new WP_Query($query_args);
			$count_post = $query->found_posts;

            $flag = rand(1, 99999);
            ob_start();
            ?>
            <div class="sp-sc-post-questions tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>  search-<?php echo esc_attr($flag); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php if (!empty($sec_title)) { ?>
                        <h2><?php echo esc_attr($sec_title); ?></h2>
                    <?php } ?>
                    <div class="sp-searchQBox">
                        <form class="sp-qform-search">
                            <input type="text" name="search_string" id="ask_search_question" value="" class="form-control field-control  suggestquestion autocomplete-input" placeholder="<?php esc_html_e('E.g. I am a 25yr old male &amp; have backache for last 2 months', 'listingo_vc_shortcodes'); ?>">
                            <input class="submitquestion" data-toggle="modal" id="ask_btn" type="button" data-target=".AskQ" value="<?php esc_html_e('SUBMIT QUESTION', 'listingo_vc_shortcodes'); ?>">
                        </form>
                        <?php
                        $script = "jQuery(document).ready(function (e) {
                                jQuery( '.search-" . esc_attr($flag) . " .suggestquestion' ).on('input', function(){	
                                                var _this = jQuery(this);	
                                                var dataString = _this.val();	
                                                if( dataString == '' ){
                                                        return false;
                                                }
                                                var ajaxurl = scripts_vars.ajaxurl;		
                                                var sp_action = 'sp_autocomplete_q_suggestions';
                                                jQuery('.sp-qform-search input[name=search_string]').autocomplete({
                                                        source: function(req, response){
                                                                $.getJSON(ajaxurl+'?callback=?&action='+sp_action, req, response);			            	            		         
                                                                jQuery('.ui-autocomplete.ui-front').css('display', 'block');               
                                                        },
                                                        select: function(event, ui) {		        	
                                                                window.location.href=ui.item.link;    
                                                        },		        
                                                        response: function(event, ui) {
                                                                if (ui.content.length === 0) {
                                                                        //do action
                                                                } 
                                                        },		        
                                                        minLength: 0,
                                                });	

                                        //Set matched string to bold 	
                                        $.ui.autocomplete.prototype._renderItem = function (ul, item) {	   	
                                                var t = String(item.value).replace(
                                                                new RegExp(this.term, 'gi'),
                                                                '<b>$&</b>');
                                                return $('<li></li>')
                                                        .data('item.autocomplete', item)
                                                        .append('' + t + '')
                                                        .appendTo(ul);
                                        }
                                });
                        } );";
                        wp_add_inline_script('jquery-ui-core', $script, 'after');
                        ?>
                    </div>
                </div>
                <?php if (!empty($recent) && $recent === 'yes') { ?>
                    <div class="tg-content tg-companyfeaturebox">
                        <?php
                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                global $post;
                                $question_by = get_post_meta($post->ID, 'question_by', true);
                                $question_to = get_post_meta($post->ID, 'question_to', true);
                                $category = get_post_meta($post->ID, 'question_cat', true);

                                $category_icon = '';
                                $category_color = '';
                                $bg_color = '';

                                if (function_exists('fw_get_db_post_option') && !empty($category)) {
                                    $categoy_bg_img = fw_get_db_post_option($category, 'category_image', true);
                                    $category_icon = fw_get_db_post_option($category, 'category_icon', true);
                                    $category_color = fw_get_db_post_option($category, 'category_color', true);

                                    $bg_color = fw_get_db_post_option($category, 'category_color', true);
                                    if (!empty($bg_color)) {
                                        $bg_color = 'style=background:' . $bg_color;
                                    }
                                }
                                ?>
                                <div class="col-xs-12 col-sm-12 col-md-6  col-lg-6 tg-verticaltop">
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
                                                        <figure class="tg-docimg"><em><img src="<?php echo esc_url($category_icon['url']); ?>" alt="<?php esc_html_e('category', 'listingo_vc_shortcodes'); ?>"></em></figure>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <div class="tg-questionbottom">
                                                    <div class="sp-title-holder">
                                                        <h4><a href="<?php echo esc_url(get_permalink()); ?>"> <?php echo esc_attr(get_the_title()); ?> </a></h4>
                                                        <?php if (!empty($category)) { ?>
                                                            <a class="tg-themetag tg-categorytag" <?php echo esc_attr($bg_color); ?> href="<?php echo esc_url(get_permalink($category)); ?>">
                                                                <?php echo esc_attr(get_the_title($category)); ?>
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                    <?php
                                                    if (function_exists('fw_get_db_settings_option') && fw_ext('questionsanswers')){
                                                        fw_ext_get_total_votes_and_answers_html($post->ID);
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if (function_exists('fw_get_db_settings_option') && fw_ext('questionsanswers')){?>
											<div class="tg-matadatahelpfull">
												<?php fw_ext_get_views_and_time_html($post->ID); ?>
												<?php fw_ext_get_votes_html($post->ID, esc_html__('Is this helpful?', 'listingo_vc_shortcodes')); ?>
											</div>
                                        <?php }?>
                                    </div>
                                </div>
                                <?php
                            } wp_reset_postdata();
                        }
                        ?>
                        <?php if (isset($count_post) && $count_post > $show_posts) : ?>
                            <div class="col-md-12">
                                <?php listingo_prepare_pagination($count_post, $show_posts); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php } ?>
                <div class="modal fade tg-modalmanageteam AskQ" tabindex="-1">
                    <div class="modal-dialog tg-modaldialog" role="document">
                        <div class="modal-content tg-modalcontent tg-add-questions">
                            <div class="tg-modalhead">
                                <h2><?php esc_html_e('Ask a Question', 'listingo_vc_shortcodes'); ?></h2>
                            </div>
                            <div class="tg-modalbody">
                                <form class="tg-themeform fw_ext_questions_form">
                                    <fieldset>
                                        <div class="form-group">
                                            <input type="text" class="question_title" name="question_title" placeholder="<?php esc_html_e('Question title', 'listingo_vc_shortcodes'); ?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="tg-select">
                                                <select name="category">
                                                    <option value=""><?php esc_html_e('Select Category', 'listingo_vc_shortcodes'); ?></option>
                                                    <?php listingo_get_categories('', 'sp_categories'); ?>
                                                </select>
                                            </span>
                                        </div>
                                        <textarea class="question_details" name="question_description" placeholder="<?php esc_html_e('Ask question here', 'listingo_vc_shortcodes'); ?>"></textarea>
                                        <?php wp_nonce_field('listingo_question_answers_nounce', 'listingo_question_answers_nounce'); ?>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="tg-modalfoot">
                                <a href="javascript:;" class="tg-btn fw_ext_question_save_btn"  data-type="open" type="submit"><?php esc_html_e('Ask a Question', 'listingo_vc_shortcodes'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_Listingo_Post_Questions();
}
