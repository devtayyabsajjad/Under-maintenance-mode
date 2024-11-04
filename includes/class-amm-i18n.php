<?php

class AMM_i18n {

    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            'advanced-maintenance-mode',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}