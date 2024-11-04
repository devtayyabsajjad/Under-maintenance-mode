<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo esc_html($title); ?></title>
    <?php wp_head(); ?>
    <style>
        body.amm-maintenance-mode {
            background-image: url('<?php echo esc_url($image_url); ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body <?php body_class('amm-maintenance-mode'); ?>>
    <div class="amm-maintenance-content">
        <h1><?php echo esc_html($title); ?></h1>
        <div class="amm-maintenance-message">
            <?php echo wp_kses_post($message); ?>
        </div>
        <?php if (!empty($social_icons)) : ?>
            <div class="amm-social-icons">
                <?php foreach ($social_icons as $icon) : ?>
                    <a href="<?php echo esc_url($icon['url']); ?>" target="_blank" rel="noopener noreferrer" class="amm-social-icon-<?php echo esc_attr($icon['type']); ?>">
                        <span class="screen-reader-text"><?php echo esc_html(ucfirst($icon['type'])); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($footer_text)) : ?>
        <div class="amm-footer-text" style="color: <?php echo esc_attr($footer_color); ?>;">
            <?php echo wp_kses_post($footer_text); ?>
        </div>
    <?php endif; ?>
    <?php wp_footer(); ?>
</body>
</html>