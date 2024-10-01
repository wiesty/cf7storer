<?php


function wm_add_settings_page()
{
    add_options_page(
        'CF7Storer Settings',
        'CF7Storer',
        'manage_options',
        'cf7storer',
        'wm_render_settings_page'
    );
}

// Registriere Einstellungen
function wm_register_settings() {
    register_setting('wm_cf7storer_settings', 'wm_store_files');
    register_setting('wm_cf7storer_settings', 'wm_secure_mode');
    register_setting('wm_cf7storer_settings', 'wm_custom_upload_path');

    add_settings_section(
        'wm_cf7storer_main_section',
        'Upload Settings',
        null,
        'cf7storer'
    );

    add_settings_field(
        'wm_store_files_field',
        'Store Files',
        'wm_store_files_callback',
        'cf7storer',
        'wm_cf7storer_main_section'
    );

    add_settings_field(
        'wm_secure_mode_field',
        'Secure Mode',
        'wm_secure_mode_callback',
        'cf7storer',
        'wm_cf7storer_main_section'
    );

    add_settings_field(
        'wm_custom_upload_path_field',
        'Custom Upload Path',
        'wm_custom_upload_path_callback',
        'cf7storer',
        'wm_cf7storer_main_section'
    );
}


function wm_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>CF7Storer Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('wm_cf7storer_settings');
            do_settings_sections('cf7storer');
            submit_button();
            ?>
        </form>
    </div>
    <script>
        // JavaScript, um das Pfadfeld nur bei aktiviertem Secure Mode anzuzeigen
        document.addEventListener('DOMContentLoaded', function() {
            const secureModeCheckbox = document.querySelector('input[name="wm_secure_mode"]');
            const pathField = document.querySelector('#wm_custom_upload_path_field');
            const pathFieldDescription = document.querySelector('#wm_custom_upload_path_description');

            const togglePathField = () => {
                const isChecked = secureModeCheckbox.checked;
                pathField.style.display = isChecked ? 'table-row' : 'none';
                pathFieldDescription.style.display = isChecked ? 'block' : 'none';
            };

            secureModeCheckbox.addEventListener('change', togglePathField);
            togglePathField();
        });
    </script>
    <?php
}


function wm_store_files_callback() {
    $store_files = get_option('wm_store_files', false);
    echo '<input type="checkbox" name="wm_store_files" value="1"' . checked(1, $store_files, false) . '>';
    echo '<p class="description">Enable this option to store files. When "Secure Mode" is off, files will be hashed and stored in <code>wp-content/uploads/cf7uploads</code>.</p>';
}


function wm_secure_mode_callback() {
    $secure_mode = get_option('wm_secure_mode', false);
    echo '<input type="checkbox" name="wm_secure_mode" value="1"' . checked(1, $secure_mode, false) . '>';
    echo '<p class="description">Enable this option to use a custom path for storing files outside the web root. File names will not be hashed in secure mode.</p>';
}


function wm_custom_upload_path_callback() {
    $custom_upload_path = esc_attr(get_option('wm_custom_upload_path', ''));
    echo '<input type="text" name="wm_custom_upload_path" id="wm_custom_upload_path_field" value="' . $custom_upload_path . '" placeholder="/var/www/vhosts/yourdomain.com/cf7uploads">';
    echo '<p id="wm_custom_upload_path_description" class="description">Define a custom path for storing files outside the web root directory.</p>';
}
