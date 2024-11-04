(function($) {
    'use strict';

    $(function() {
        var file_frame;
        var socialIconIndex = $('.amm-social-icon').length;

        $('.amm-color-picker').wpColorPicker();

        $('#amm_upload_image_button').on('click', function(event) {
            event.preventDefault();
            openMediaUploader($(this), $('#amm_image_url'), $('#amm_image_preview'));
        });

        $('#amm-add-social-icon').on('click', function(event) {
            event.preventDefault();
            var newIcon = `
                <div class="amm-social-icon">
                    <select name="amm_settings[social_icons][${socialIconIndex}][type]">
                        <option value="facebook">Facebook</option>
                        <option value="instagram">Instagram</option>
                        <option value="twitter">X (Twitter)</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="youtube">YouTube</option>
                    </select>
                    <input type="text" name="amm_settings[social_icons][${socialIconIndex}][url]" placeholder="Social Icon URL" />
                    <button type="button" class="button amm-remove-icon">Remove</button>
                </div>
            `;
            $('#amm-social-icons').append(newIcon);
            socialIconIndex++;
        });

        $(document).on('click', '.amm-remove-icon', function() {
            $(this).closest('.amm-social-icon').remove();
        });

        function openMediaUploader(button, input, preview) {
            if (file_frame) {
                file_frame.open();
                return;
            }

            file_frame = wp.media.frames.file_frame = wp.media({
                title: 'Select or Upload Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });

            file_frame.on('select', function() {
                var attachment = file_frame.state().get('selection').first().toJSON();
                input.val(attachment.url);
                if (preview) {
                    preview.html('<img src="' + attachment.url + '" alt="Preview Image" style="max-width: 300px; height: auto;" />');
                }
            });

            file_frame.open();
        }
    });

})(jQuery);