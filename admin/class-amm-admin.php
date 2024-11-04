<?php

class AMM_Admin {

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, AMM_PLUGIN_URL . 'admin/css/amm-admin.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts($hook) {
        if ($hook != 'settings_page_' . $this->plugin_name) {
            return;
        }

        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script($this->plugin_name, AMM_PLUGIN_URL . 'admin/js/amm-admin.js', array('jquery', 'wp-color-picker'), $this->version, false);
        wp_enqueue_media();
    }

    public function add_plugin_admin_menu() {
        add_options_page(
            'Advanced Maintenance Mode Settings',
            'Maintenance Mode',
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_setup_page')
        );
    }

    public function display_plugin_setup_page() {
        include_once AMM_PLUGIN_DIR . 'admin/partials/amm-admin-display.php';
    }

    public function register_settings() {
        register_setting($this->plugin_name, 'amm_settings', array($this, 'validate_settings'));
    }

    public function validate_settings($input) {
        $valid = array();
        $valid['active'] = isset($input['active']) ? 1 : 0;
        $valid['specific_pages'] = sanitize_textarea_field($input['specific_pages']);
        $valid['whitelisted_users'] = isset($input['whitelisted_users']) ? array_map('intval', $input['whitelisted_users']) : array();
        $valid['title'] = sanitize_text_field($input['title']);
        $valid['message'] = wp_kses_post($input['message']);
        $valid['image_url'] = esc_url_raw($input['image_url']);

        // Validate social icons
        $valid['social_icons'] = array();
        if (isset($input['social_icons']) && is_array($input['social_icons'])) {
            foreach ($input['social_icons'] as $icon) {
                if (!empty($icon['type']) && !empty($icon['url'])) {
                    $valid['social_icons'][] = array(
                        'type' => sanitize_text_field($icon['type']),
                        'url' => esc_url_raw($icon['url'])
                    );
                }
            }
        }

        $valid['footer_text'] = wp_kses_post($input['footer_text']);
        $valid['footer_color'] = sanitize_hex_color($input['footer_color']);

        return $valid;
    }
}