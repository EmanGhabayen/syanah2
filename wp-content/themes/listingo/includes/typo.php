<?php
/**
 * @Set Post Views
 * @return {}
 */
if (!function_exists('listingo_add_dynamic_styles')) {

    function listingo_add_dynamic_styles() {

        if (function_exists('fw_get_db_settings_option')) {
            $color_base = fw_get_db_settings_option('color_settings');
            $enable_typo = fw_get_db_settings_option('enable_typo');
            $background = fw_get_db_settings_option('background');
            $custom_css = fw_get_db_settings_option('custom_css');
            $body_font = fw_get_db_settings_option('body_font');
            $body_p = fw_get_db_settings_option('body_p');
            $h1_font = fw_get_db_settings_option('h1_font');
            $h2_font = fw_get_db_settings_option('h2_font');
            $h3_font = fw_get_db_settings_option('h3_font');
            $h4_font = fw_get_db_settings_option('h4_font');
            $h5_font = fw_get_db_settings_option('h5_font');
            $h6_font = fw_get_db_settings_option('h6_font');
            $demo_typography = fw_get_db_settings_option('demo_typography');
        }

        $post_name = listingo_get_post_name();

        if (isset($_SERVER["SERVER_NAME"]) && $_SERVER["SERVER_NAME"] === 'themographics.com') {
			
            if ( $post_name === 'home-v5' 
				|| $post_name === 'home-page-8'
				|| $post_name === 'home-v2'
				|| $post_name === 'header-v2' 
			) {
                $color_base['gadget'] = 'custom';
            }
        }

        ob_start();

        echo (isset($custom_css)) ? $custom_css : '';

        if (isset($enable_typo) && $enable_typo == 'on') {
            ?>
            body{<?php echo listingo_extract_typography($body_font); ?>}
            body p{<?php echo listingo_extract_typography($body_p); ?>}
            body ul {<?php echo listingo_extract_typography($body_font); ?>}
            body li {<?php echo listingo_extract_typography($body_font); ?>}
            body h1{<?php echo listingo_extract_typography($h1_font); ?>}
            body h2{<?php echo listingo_extract_typography($h2_font); ?>}
            body h3{<?php echo listingo_extract_typography($h3_font); ?>}
            body h4{<?php echo listingo_extract_typography($h4_font); ?>}
            body h5{<?php echo listingo_extract_typography($h5_font); ?>}
            body h6{<?php echo listingo_extract_typography($h6_font); ?>}
        <?php } ?>

        <?php
        if (isset($color_base['gadget']) && $color_base['gadget'] === 'custom') {
            if (!empty($color_base['custom']['primary_color'])) {
                $theme_color = $color_base['custom']['primary_color'];
				
                $theme_color = apply_filters('listingo_get_page_color', $theme_color);
                ?>

                /*Theme background Color*/
                .tg-btn:before,
				.tg-theme-tag,
				.tg-dropdownmenu li a:before,
				.tg-navigation ul li a:after,
				.tg-searchbox,
				.tg-formsearch .tg-btn:hover:before,
				.tg-panel .tg-radio label:hover,
				.tg-panel .tg-radio input[type=radio]:checked + label,
				.tg-featuredprofiles h1 span:before,
				.tg-featuredprofilesbtns .tg-btnprev:hover i,
				.tg-featuredprofilesbtns .tg-btnnext:hover i,
				.tg-themetag:before,
				.tg-quotes,
				.navbar-toggle,
				.tg-dropdowarrow,
				.tg-bordertitle:before,
				.tg-timelinenav li a:hover:after,
				.tg-timelinenav li.active a:after,
				.tg-formrefinesearch fieldset h4:before,
				.tg-btngallery,
				.tg-widgettitle:before,
				.tg-widgetcontent .tg-tag:hover,
				.tg-currentday .tg-timebox i,
				.tg-tabnav li:hover a,
				.tg-tabnav li.active a,
				.tg-formprogressbar li:after,
				.tg-tablejoblidting tr:before,
				.ui-slider-range,
				.tg-dashboardnav ul li a:before,
				.alert-success i,
				.tg-btnrefresh:hover,
				.tg-servicesmodal .tg-modalcontent .close,
				.tg-btnaction li.tg-email a,
				.tg-addtimeslot:hover,
				.tg-actionnav li:hover,
				.tg-emailnav li .form-group button,
				.tg-emailnav li:before,
				.tg-btnactions a:hover,
				.tg-btndownloadattachment,
				.tg-dashboardappointment .tg-btntimeedit .tg-btnedite,
				.geo_distance.ui-slider .ui-slider-handle,
				.pin, 
				.tg-uploadingbar-percentage,
				.tg-formleavefeedback .tg-servicesrating li > em + div strong,
				.tg-contactusarea .tg-themeform .tg-btn,
				.post-password-form p input[type=submit],
				.checkout_coupon p + p input[type=submit],
				html input[type="button"],
				input[type="reset"],
				input[type="submit"],
				.checkout-button.button.alt.wc-forward,
				.sp-header-v2 .tg-rightarea .tg-btn:hover,
				.sp-search-provider-banner-v2 .tg-formsearch .tg-btn,
				.tg-headervtwo .tg-navigationarea,
				.owl-dots .owl-dot:hover span,
				.owl-dots .owl-dot.active span,
				.tg-headervthree .tg-navigationarea
				.tg-btnedite,
				.tg-uploadhead,
				.tg-uploadingbar:after,
				.tg-galleryimg figure figcaption .fa-check,
				.tg-expireytimecounter,
				.tg-timecounter,
				.button.logout-link,
				#bbpress-forums #bbp-search-form input[type="submit"],
				#bbpress-forums + #bbp-search-form > div input[type="submit"],
				.tg-headervthree .tg-navigationarea,
				.sp-view-profile,
				.added_to_cart.wc-forward:before,
				.sp-av-link,
				.tg-pagination .page-numbers li .page-numbers.current,
				.wc-stripe-checkout-button,
				.tg-btnsearchvtwo,
				.tg-headervfour .tg-btnregister,
				.tg-navigationareavtwo .tg-navigation > ul > li > a:after,
				.tg-btnvtwo.tg-btn:before,
				.tg-sectionheadvtwo span:before,
				.tg-sectionheadvtwo span:after,
				.tg-questiondetails,
				.tg-counterswork,
				.tg-bgcolor,
				.tg-searchheadform fieldset .tg-btnsearchvtwo:hover,
				.tg-btnsearcharea .tg-btnsearchvtwo:hover,
				.tg-headervfour .tg-btndropdown,
				.tg-headervfour .tg-loginregister,
				.tg-datepicker .ui-datepicker td a.ui-state-active,
				.tg-datepicker .ui-datepicker td a:hover,
				.tg-datepicker .ui-widget-header a:hover,
				.tg-timeslotsradio .tg-radio input[type=radio]:checked + label,
				.tg-closemodal,
				.fw-contact-form input[type="submit"]:hover,
				.fw-package .fw-heading-row,
				.fw-package .fw-pricing-row,
				.format-status .entry-content .page-links a, 
				.format-gallery .entry-content .page-links a, 
				.format-chat .entry-content .page-links a, 
				.format-quote .entry-content .page-links a, 
				.page-links a,
				.sp-header-v3:before,
				.sp-header-v4:before,
                .tg-datepicker .ui-datepicker td a.ui-state-active,
                .tg-datepicker .ui-datepicker td a:hover,
                .tg-datepicker .ui-widget-header a:hover,
                .tg-timeslotsradio .tg-radio input[type=radio]:checked + label,
                .tg-closemodal,
                .sp-header-v2 .tg-rightarea .tg-btn:hover,
                .sp-form-search .active-view,
                .tg-qrcodedetails,
                .tg-pagination ul li.next a:hover,
                .spv4-listing .tg-pagination ul li.next a:hover,
				.tg-asidebutton .tg-btn,
				.tg-authorbtnarea .tg-btn:before,
				.loadmore-ads a,
				.featured-text-wrap,
				.tg-tabnavtwo li:after,
				.tg-homeslidervfour .pogoSlider-nav-btn--selected,
               	.tg-radiovtwo input[type=radio] + label:after
                {background:<?php echo esc_attr($theme_color); ?>;}
				
                .tg-emailnavscroll .mCSB_dragger .mCSB_dragger_bar,
				.tg-horizontalthemescrollbar .mCSB_dragger .mCSB_dragger_bar,
				.tg-themescrollbar .mCSB_dragger .mCSB_dragger_bar,
				div.bbp-submit-wrapper > .button.submit,
				.tg-dayactive,
				.tg-slidertitle:after
				{background: <?php echo esc_attr($theme_color); ?> !important;}

                /*Theme Text Color*/
                
                .tg-addressinfo li a:hover,
				.tg-inputwithicon .tg-icon.fa-crosshairs,
				.tg-sectiontitle:after,
				.tg-serviceprovidercontent .tg-title h3:hover a,
				.tg-postmatadata li a:hover,
				.tg-postmatadata li a:hover i,
				.tg-postmatadata li a:hover span,
				.tg-footernav ul li a:hover,
				.tg-widgetcontent ul li a:hover,
				.tg-widgetcontent ul li a:hover:before,
				.tg-listinglistvone .tg-serviceprovider:hover .tg-title h3 a,
				.tg-jobdetail .tg-title .tg-jobpostedby a:hover,
				.tg-themeliststylecircletick li:before,
				.tg-tabnav li.active a > span,
				.tg-tabnav li:hover a > span,
				.tg-tablejoblidting tr:hover .tg-contentbox .tg-title h3 a,
				.tg-dashboardnav ul li:hover a i,
				.tg-dashboardnav ul li.tg-active a i,
				.tg-alertmessages .alert-success strong,
				.tg-dashboardservice:hover .tg-servicetitle h2 a,
				blockquote:after,
				blockquote:before,
				.tg-iosstylcheckbox input[type=checkbox]:checked + label:before,
				.mega-menu ul li ul.sub-menu li a:hover,
				.sp-header-v2 .tg-rightarea .tg-btn,
				.locate-me-wrap .geolocate,
				.tg-nav ul li.menu-item-has-mega-menu .sub-menu li.current-menu-item a,
				.tg-navdetailpagetabs li.active a,
				.tg-popularcatagories li span a:hover,
				.tg-searchbycatagory .tg-catagory a:hover span,
				.tg-btnpostanewjob:hover,
				.tg-btnpostanewjob:hover:before,
				.tg-headervfour .tg-loginregister .tg-btnlogin,
				.sp-header-v3 .sub-menu li.current-menu-item a,
				.sp-header-v3 .sub-menu li.current-menu-item a:before,
				.sp-search-provider-banner-v2.sp-version .tg-formsearch .chosen-container .chosen-single,
				.tg-pagination ul li a:hover,
				.tg-pagination ul li.tg-active a,
                .tg-dashboardservice:hover .tg-servicetitle h2 a,
				.tg-imgandtitle h3 a:hover,
				.tg-pkgplanhead h4 span,
				.sp-upload-container:focus,
				.tg-questionsvtwo .sp-upload-container:hover i,
				.tg-questionsvtwo .sp-upload-container:hover span,
                .tg-tabnavtwo li:hover a .tg-navcontent span,
                .tg-tabnavtwo li.active a .tg-navcontent span,
                .tg-searchboxvtwo .tg-formsearch fieldset .tg-formtitle
               
                {color: <?php echo esc_attr($theme_color); ?>;}

                /*Theme Border Color*/

                .tg-theme-tag:after,
				.tg-theme-tag:before,
				input:focus,
				.tg-select select:focus,
				.form-control:focus,
				.tg-testimonialnavigationslider .item figure:hover,
				.tg-testimonialnavigationslider .current .item figure,
				.tg-navigationarea,
				.tg-timelinenav li a:hover,
				.tg-timelinenav li.active a,
				.tg-widgetcontent .tg-tag:hover,
				.tg-btndownload:hover,
				.tg-datepicker .ui-datepicker td a:hover,
				.tg-datepicker .ui-datepicker td a.ui-state-active,
				.tg-datepicker .ui-datepicker td a.ui-state-highlight,
				.tg-timeslotsradio .tg-radio input[type=radio]:checked + label,
				.tg-tabnav li,
				.tg-iosstylcheckbox input[type=checkbox]:checked + label,
				.tg-actionnav li:hover,
				.geo_distance.ui-slider .ui-slider-handle,
				.geo_distance.ui-slider .ui-slider-handle:hover,
				.tg-formleavefeedback .tg-servicesrating li > em + div strong:before,
				.sp-header-v2 .tg-rightarea .tg-btn,
				body.rtl .tg-btndownload:hover,
				.format-status .entry-content .page-links a, 
				.format-gallery .entry-content .page-links a, 
				.format-chat .entry-content .page-links a, 
				.format-quote .entry-content .page-links a, 
				.page-links a,
				.spv4-listing .tg-pagination ul li.tg-active a,
				.spv4-listing .tg-pagination ul li a:hover,
              	.sp-form-search .active-view,
                .switch-view:hover,
                .tg-pagination ul li.tg-active a,
                .tg-pagination ul li a:hover,
                .tg-pagination ul li.next a:hover
                {border-color:<?php echo esc_attr($theme_color); ?>;}

                .pulse:after{
                -webkit-box-shadow: 0 0 1px 2px <?php echo esc_attr($theme_color); ?>;
                box-shadow: 0 0 1px 2px <?php echo esc_attr($theme_color); ?>;
                }

                .tg-formprogressbar li:after{
                -webkit-box-shadow: inset -2px -2px 2px 0 <?php echo esc_attr($theme_color); ?>;
                box-shadow: inset -2px -2px 2px 0 <?php echo esc_attr($theme_color); ?>;
                }

            <?php } ?>
            <?php
        }

        return ob_get_clean();
    }

}