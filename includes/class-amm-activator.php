<?php

class AMM_Activator {

    public static function activate() {
        if (!get_option('amm_settings')) {
            $default_settings = array(
                'active' => 0,
                'specific_pages' => '',
                'whitelisted_users' => array(),
                'title' => '',
                'message' => '',
                'image_url' => '',
                'social_icons' => array(),
                'footer_text' => '',
                'footer_color' => '#000000'
            );
            update_option('amm_settings', $default_settings);
        }
    }
}