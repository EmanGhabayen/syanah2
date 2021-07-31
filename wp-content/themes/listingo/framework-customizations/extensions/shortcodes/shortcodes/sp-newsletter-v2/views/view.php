<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$form_subheading 	= !empty($atts['form_subheading']) ? $atts['form_subheading'] : '';
$form_heading 		= !empty($atts['form_heading']) ? $atts['form_heading'] : '';
$form_img 			= !empty($atts['form_image']['url']) ? $atts['form_image']['url'] : '';
$color 				= !empty($atts['color']) ? $atts['color'] : '';
$form_btn_text 		= !empty($atts['frm_btn_txt']) ? $atts['frm_btn_txt'] : esc_html__('Signup Now','listingo');

$bordercolor	= !empty( $color ) ? $color : 'rgba(255,255,255,0.50)';
$txtcolor	= !empty( $color ) ? 'style=color:'.$color : '';
?>
<div class="sp-sc-newsletter-v2 tg-haslayout">
    <div class="row">
        <?php
        if (!empty($form_heading) || !empty($form_subheading) || !empty($form_img)) {?>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                <div class="tg-newslttercontent">
                    <?php if (!empty($form_img)) { ?>
                        <span class="tg-envelopicon"><img src="<?php echo esc_url($form_img); ?>" alt="<?php esc_html_e('newsletter', 'listingo'); ?>"></span>
                    <?php } ?>
                    <?php if (!empty($form_heading) || !empty($form_subheading)) { ?> 
                        <div class="tg-healthtips" style="border-left: 1px solid <?php echo esc_attr( $bordercolor );?>">
                            <?php if (!empty($form_subheading)) { ?>
                                <span <?php echo esc_attr( $txtcolor );?>><?php echo esc_attr($form_subheading); ?></span>
                            <?php } ?>
                            <?php if (!empty($form_heading)) { ?>
                                <h3 <?php echo esc_attr( $txtcolor );?>><?php echo esc_attr($form_heading); ?></h3>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-7">
            <form class="tg-formtheme tg-formnewsletter signup-newletter">
                <fieldset>
                    <div class="form-group tg-newslettergroup tg-inputwithicon">
                        <i class="lnr lnr-envelope"></i>
                        <input type="email" name="email" class="form-control" placeholder="<?php esc_html_e('Enter Your Email', 'listingo'); ?>">
                    </div>
                    <button type="submit" class="tg-btn subscribe_me"><?php echo esc_attr($form_btn_text); ?></button>
                </fieldset>
            </form>
        </div>
    </div>
</div>