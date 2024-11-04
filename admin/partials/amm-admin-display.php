<div class="wrap">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    <form method="post" action="options.php">
        <?php
        settings_fields($this->plugin_name);
        $options = get_option('amm_settings');
        ?>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="amm_active"><?php _e('Activate Maintenance Mode', 'advanced-maintenance-mode'); ?></label>
                </th>
                <td>
                    <input type="checkbox" id="amm_active" name="amm_settings[active]" value="1" <?php checked($options['active'], 1); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="amm_specific_pages"><?php _e('Activate on Specific Pages/Posts', 'advanced-maintenance-mode'); ?></label>
                </th>
                <td>
                    <textarea id="amm_specific_pages" name="amm_settings[specific_pages]" rows="5" cols="50"><?php echo esc_textarea($options['specific_pages']); ?></textarea>
                    <p class="description"><?php _e('Enter URLs of specific pages/posts, one per line.', 'advanced-maintenance-mode'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="amm_whitelisted_users"><?php _e('Whitelist Specific Users', 'advanced-maintenance-mode'); ?></label>
                </th>
                <td>
                    <?php
                    $users = get_users();
                    $whitelisted_users = isset($options['whitelisted_users']) ? $options['whitelisted_users'] : array();
                    ?>
                    <select id="amm_whitelisted_users" name="amm_settings[whitelisted_users][]" multiple>
                        <?php foreach ($users as $user) : ?>
                            <option value="<?php echo $user->ID; ?>" <?php selected(in_array($user->ID, $whitelisted_users), true); ?>>
                                <?php echo esc_html($user->display_name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="amm_title"><?php _e('Maintenance Page Title', 'advanced-maintenance-mode'); ?></label>
                </th>
                <td>
                    <input type="text" id="amm_title" name="amm_settings[title]" value="<?php echo esc_attr($options['title']); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="amm_message"><?php _e('Maintenance Page Message', 'advanced-maintenance-mode'); ?></label>
                </th>
                <td>
                    <?php
                    wp_editor(
                        $options['message'],
                        'amm_message',
                        array(
                            'textarea_name' => 'amm_settings[message]',
                            'textarea_rows' => 5,
                            'media_buttons' => false,
                        )
                    );
                    ?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="amm_image"><?php _e('Maintenance Page Image', 'advanced-maintenance-mode'); ?></label>
                </th>
                <td>
                    <input type="text" id="amm_image_url" name="amm_settings[image_url]" value="<?php echo esc_url($options['image_url']); ?>" class="regular-text" />
                    <input type="button" id="amm_upload_image_button" class="button" value="<?php _e('Upload Image', 'advanced-maintenance-mode'); ?>" />
                    <p class="description"><?php _e('Upload or select an image for the maintenance page.', 'advanced-maintenance-mode'); ?></p>
                    <div id="amm_image_preview">
                        <?php if (!empty($options['image_url'])) : ?>
                            <img src="<?php echo esc_url($options['image_url']); ?>" alt="Maintenance Page Image" style="max-width: 300px; height: auto;" />
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        </table>

        <h3><?php _e('Social Icons', 'advanced-maintenance-mode'); ?></h3>
        <div id="amm-social-icons">
            <?php
            $social_icons = isset($options['social_icons']) ? $options['social_icons'] : array();
            $available_icons = array(
                'facebook' => 'Facebook',
                'instagram' => 'Instagram',
                'twitter' => 'X (Twitter)',
                'whatsapp' => 'WhatsApp',
                'youtube' => 'YouTube'
            );
            foreach ($social_icons as $index => $icon) :
            ?>
            <div class="amm-social-icon">
                <select name="amm_settings[social_icons][<?php echo $index; ?>][type]">
                    <?php foreach ($available_icons as $value => $label) : ?>
                        <option value="<?php echo $value; ?>" <?php selected($icon['type'], $value); ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="amm_settings[social_icons][<?php echo $index; ?>][url]" value="<?php echo esc_url($icon['url']); ?>" placeholder="<?php _e('Social Icon URL', 'advanced-maintenance-mode'); ?>" />
                <button type="button" class="button amm-remove-icon"><?php _e('Remove', 'advanced-maintenance-mode'); ?></button>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" id="amm-add-social-icon" class="button"><?php _e('Add New Social Icon', 'advanced-maintenance-mode'); ?></button>

        <h3><?php _e('Footer Text', 'advanced-maintenance-mode'); ?></h3>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="amm_footer_text"><?php _e('Footer Content', 'advanced-maintenance-mode'); ?></label>
                </th>
                <td>
                    <?php
                    wp_editor(
                        isset($options['footer_text']) ? $options['footer_text'] : '',
                        'amm_footer_text',
                        array(
                            'textarea_name' => 'amm_settings[footer_text]',
                            'textarea_rows' => 5,
                            'media_buttons' => false,
                        )
                    );
                    ?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="amm_footer_color"><?php _e('Footer Text Color', 'advanced-maintenance-mode'); ?></label>
                </th>
                <td>
                    <input type="text" id="amm_footer_color" name="amm_settings[footer_color]" value="<?php echo  esc_attr(isset($options['footer_color']) ? $options['footer_color'] : '#000000'); ?>" class="amm-color-picker" data-default-color="#000000" />
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>