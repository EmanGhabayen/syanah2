<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Search_Question')) {

    class SC_VC_Skin_Listingo_Search_Question extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_search_question", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "heading" => '',
                "form_image" => '',
                "show_recent" => 'yes',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class  = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_search_question', $args);
            $classes 	= array();
            $classes[]  = $custom_classes;
            $classes[]  = $css_class;

            global $paged;
            $pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
            $pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
            //paged works on single pages, page - works on homepage
            $paged = max($pg_page, $pg_paged);

            $order = 'DESC';
            $orderby = 'ID';
            $show_posts = get_option('posts_per_page');
            $flag = rand(1, 99999);


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

            $thumb_meta = array();
            $thumbnail = '';
            if (!empty($form_image)) {
                $thumb_meta = $this->listingo_vc_shortcodes_get_image_metadata($form_image);
                $thumbnail = $this->listingo_vc_shortcodes_get_image_source($form_image, 0, 0);
                $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $thumb_meta['title'];
            }
            ob_start();
            ?>
            <div class="sp-sc-search-questions tg-haslayout search-<?php echo esc_attr($flag); ?> <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
                    <div class="tg-questiondetails">
                        <?php if (!empty($thumbnail)) { ?>
                            <figure>
                                <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                            </figure>
                        <?php } ?>
                        <?php if (!empty($heading)) { ?>
                            <div class="tg-title">
                                <h3><?php echo esc_attr($heading); ?></h3>
                            </div>
                        <?php } ?>
                        <form class="fw_ext_questions_form sp-qform-search tg-formtheme tg-formquestion">
                            <fieldset>
                                <div class="form-group tg-inputwithicon">
                                    <i class="lnr lnr-magnifier"></i>
                                    <input type="text" name="search_string" id="ask_search_question" value="" class="form-control suggestquestion autocomplete-input" placeholder="<?php esc_html_e('E.g. I am a 25yr old male &amp; have backache for last 2 months', 'listingo_vc_shortcodes'); ?>">
                                    <a  data-toggle="modal" id="ask_btn" type="button" data-target="#tg-quickview"><?php esc_html_e('Submit Now', 'listingo_vc_shortcodes'); ?></a>
                                </div>
                            </fieldset>
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
                <div class="tg-askquestionmodal modal fade" id="tg-quickview" tabindex="-1">
                    <div class="tg-modaldialog modal-dialog" role="document">
                        <button type="button" class="close" data-dismiss="modal"><em class="lnr lnr-cross"></em></button>
                        <div class="tg-modalcontentvtow modal-content tg-add-questions">
                            <div class="tg-modaltitle">
                                <span><?php esc_html_e('Ask Question in Privacy', 'listingo_vc_shortcodes'); ?> &amp;</span>
                                <h2><?php esc_html_e('Get A Professional Help', 'listingo_vc_shortcodes') ?></h2>
                            </div>
                            <div class="tg-modelddescription">
                                <?php wpautop('Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enimiad minimae veniam quistane nostrud exercitation ullamco laboris nisiut.', 'listingo_vc_shortcodes'); ?>
                            </div>
                            <div class="tg-modalbody modal-body">
                                <form class="fw_ext_questions_form tg-themeform tg-formmodalbox">
                                    <fieldset>
                                        <div class="form-group tg-inputwithicon">
                                            <i class="lnr lnr-pencil"></i>
                                            <input type="text" class="question_title form-control" name="question_title" placeholder="<?php esc_html_e('Type Title Here', 'listingo_vc_shortcodes'); ?>">
                                        </div>
                                        <div class="form-group tg-inputwithicon">
                                            <i class="lnr lnr-layers"></i>
                                            <span class="tg-select">
                                                <select data-placeholder="<?php esc_html_e('Type Or Slect Category', 'listingo_vc_shortcodes'); ?>" name="category">
                                                    <option value=""><?php esc_html_e('Select Category', 'listingo_vc_shortcodes'); ?></option>
                                                    <?php listingo_get_categories('', 'sp_categories'); ?>
                                                </select>
                                            </span>
                                        </div>
                                        <div class="form-group tg-inputwithicon">
                                            <i class="lnr lnr-bubble"></i>
                                            <textarea class="question_details" name="question_description" placeholder="<?php esc_html_e('Your Question', 'listingo_vc_shortcodes'); ?>"></textarea>  
                                        </div>
                                        <?php wp_nonce_field('listingo_question_answers_nounce', 'listingo_question_answers_nounce'); ?>
                                    </fieldset>
                                </form>
                            </div>
                            <a href="javascript:;" class="tg-btn tg-btnvtwo fw_ext_question_save_btn"  data-type="open" type="submit"><?php esc_html_e('Ask Now', 'listingo_vc_shortcodes'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

    }

    new SC_VC_Skin_Listingo_Search_Question();
}
