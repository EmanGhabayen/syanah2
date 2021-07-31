<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
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
?>
<div class="sp-sc-search-questions tg-haslayout search-<?php echo esc_attr($flag); ?>">
    <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
        <div class="tg-questiondetails">
            <?php if (!empty($atts['form_image']['url'])) { ?>
                <figure>
                    <img src="<?php echo esc_url($atts['form_image']['url']); ?>" alt="<?php esc_html_e('Form Image', 'listingo'); ?>">
                </figure>
            <?php } ?>
            <?php if (!empty($atts['heading'])) { ?>
                <div class="tg-title">
                    <h3><?php echo esc_attr($atts['heading']); ?></h3>
                </div>
            <?php } ?>
            <form class="sp-qform-search tg-formtheme tg-formquestion">
                <fieldset>
                    <div class="form-group tg-inputwithicon">
                        <i class="lnr lnr-magnifier"></i>
                        <input type="text" name="search_string" id="ask_search_question" value="" class="form-control suggestquestion autocomplete-input" placeholder="<?php esc_html_e('E.g. I am a 25yr old male &amp; have backache for last 2 months', 'listingo'); ?>">
                        <a class="submitquestion" data-toggle="modal" id="ask_btn" type="button" data-target="#tg-quickview"><?php esc_html_e('Submit Now', 'listingo'); ?></a>
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
        <div class="tg-modaldialog modal-dialog tg-add-questions" role="document">
            <button type="button" class="close" data-dismiss="modal"><em class="lnr lnr-cross"></em></button>
            <div class="tg-modalcontentvtow modal-content ">
                <div class="tg-modaltitle">
                    <span><?php esc_html_e('Ask Question in Privacy', 'listingo'); ?>&amp;</span>
                    <h2><?php esc_html_e('Get A Professional Help', 'listingo') ?></h2>
                </div>
                <div class="tg-modelddescription">
                    <?php wpautop('Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enimiad minimae veniam quistane nostrud exercitation ullamco laboris nisiut.', 'listingo'); ?>
                </div>
                <div class="tg-modalbody modal-body">
                    <form class="fw_ext_questions_form tg-themeform tg-formmodalbox">
                        <fieldset>
                            <div class="form-group tg-inputwithicon">
                                <i class="lnr lnr-pencil"></i>
                                <input type="text" class="question_title form-control" name="question_title" placeholder="<?php esc_html_e('Type Title Here', 'listingo'); ?>">
                            </div>
                            <div class="form-group tg-inputwithicon">
                                <i class="lnr lnr-layers"></i>
                                <span class="tg-select">
                                    <select data-placeholder="<?php esc_html_e('Type Or Slect Category', 'listingo'); ?>" name="category">
                                        <option value=""><?php esc_html_e('Select Category', 'listingo'); ?></option>
                                        <?php listingo_get_categories('', 'sp_categories'); ?>
                                    </select>
                                </span>
                            </div>
                            <div class="form-group tg-inputwithicon">
                                <i class="lnr lnr-bubble"></i>
                                <textarea class="question_details" name="question_description" placeholder="<?php esc_html_e('Your Question', 'listingo'); ?>"></textarea>  
                            </div>
                            <?php wp_nonce_field('listingo_question_answers_nounce', 'listingo_question_answers_nounce'); ?>
                        </fieldset>
                    </form>
                </div>
                <a href="javascript:;" class="tg-btn tg-btnvtwo fw_ext_question_save_btn"  data-type="open" type="submit"><?php esc_html_e('Ask Now', 'listingo'); ?></a>
            </div>
        </div>
    </div>
</div>