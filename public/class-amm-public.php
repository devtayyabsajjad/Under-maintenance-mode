<?php

class AMM_Public {

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, AMM_PLUGIN_URL . 'public/css/amm-public.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, AMM_PLUGIN_URL . 'public/js/amm-public.js', array('jquery'), $this->version, false);
    }

    public function check_maintenance_mode() {
        $options = get_option('amm_settings');
        
        if (empty($options) || !is_array($options)) {
            return;
        }

        if (empty($options['active'])) {
            return;
        }

        // Allow admin users to preview the site
        if (current_user_can('manage_options') && !isset($_GET['preview_maintenance'])) {
            return;
        }

        if (is_user_logged_in() && !empty($options['whitelisted_users']) && in_array(get_current_user_id(), $options['whitelisted_users'])) {
            return;
        }

        $current_url = home_url($_SERVER['REQUEST_URI']);
        if (!empty($options['specific_pages'])) {
            $pages = array_map('trim', explode("\n", $options['specific_pages']));
            if (!in_array($current_url, $pages)) {
                return;
            }
        }

        $this->display_maintenance_page();
        exit;
    }

    private function display_maintenance_page() {
        $options = get_option('amm_settings');
        $title = !empty($options['title']) ? $options['title'] : __('We\'re under maintenance', 'advanced-maintenance-mode');
        $message = !empty($options['message']) ? $options['message'] : __('We\'ll be back soon!', 'advanced-maintenance-mode');
        $image_url = !empty($options['image_url']) ? $options['image_url'] : '';
        $social_icons = !empty($options['social_icons']) ? $options['social_icons'] : array();
        $footer_text = !empty($options['footer_text']) ? $options['footer_text'] : '';
        $footer_color = !empty($options['footer_color']) ? $options['footer_color'] : '#000000';

        include_once AMM_PLUGIN_DIR . 'public/partials/amm-public-display.php';
    }
}