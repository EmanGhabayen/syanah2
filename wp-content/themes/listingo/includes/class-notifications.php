<?php

/**
 *
 * Class used as base to create theme Notifications
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
if (!class_exists('Listingo_Prepare_Notification')) {

    class Listingo_Prepare_Notification {

        function __construct() {
            // 
        }

        /**
         * 
         * @param type $message
         */
        public static function listingo_success($msg_type = '', $message = '') {
            global $post;
            $output = '';
            $output .= '<div class = "alert alert-success tg-alertmessage fade in">';
            $output .= '<i class = "lnr lnr-star"></i>';
            $output .= '<span>';
            $output .= '<strong>' . esc_attr( $msg_type ) . ' : </strong>';
            $output .= $message;
            $output .= '</span>';
            $output .= '</div>';
            echo force_balance_tags($output);
        }

        /**
         * 
         * @param type $message
         */
        public static function listingo_error($msg_type = '', $message = '') {
            global $post;
            $output = '';
            $output .= '<div class = "alert alert-danger tg-alertmessage fade in">';
            $output .= '<i class = "lnr lnr-bug"></i>';
            $output .= '<span>';
            $output .= '<strong>' . esc_attr( $msg_type ) . ' : </strong>';
            $output .= $message;
            $output .= '</span>';
            $output .= '</div>';
            echo force_balance_tags($output);
        }

        /**
         * 
         * @param type $message
         */
        public static function listingo_info($msg_type = '', $message = '') {
            global $post;
            $output = '';
            $output .= '<div class = "alert alert-info tg-alertmessage fade in">';
            $output .= '<i class = "lnr lnr-flag"></i>';
            $output .= '<span>';
            $output .= '<strong>' . esc_attr( $msg_type ) . ' : </strong>';
            $output .= $message;
            $output .= '</span>';
            $output .= '</div>';
            echo force_balance_tags($output);
        }

        /**
         * 
         * @param type $message
         */
        public static function listingo_warning($msg_type = '', $message = '') {
            global $post;
            $output = '';
            $output .= '<div class = "alert alert-warning tg-alertmessage fade in">';
            $output .= '<i class = "lnr lnr-construction"></i>';
            $output .= '<span>';
            $output .= '<strong>' . esc_attr( $msg_type ) . ' : </strong>';
            $output .= $message;
            $output .= '</span>';
            $output .= '</div>';
            echo force_balance_tags($output);
        }

    }

    new Listingo_Prepare_Notification();
}
