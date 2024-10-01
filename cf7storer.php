<?php
/*
Plugin Name: CF7Storer
Description: Store all files uploaded through Contact Form 7 in a secure or hashed folder
Author: Wiestyy
Version: 2.6.0
*/

// Einbinden der notwendigen Dateien
include_once(plugin_dir_path(__FILE__) . 'includes/functions.php');
include_once(plugin_dir_path(__FILE__) . 'includes/admin-page.php');
include_once(plugin_dir_path(__FILE__) . 'includes/file-list.php');


function wm_add_files_menu_page() {
    add_menu_page(
        'Stored Files',
        'Stored Files',
        'manage_options',
        'wm-stored-files',
        'wm_render_stored_files_page',
        'dashicons-media-document',
        6 
    );
}
add_action('admin_menu', 'wm_add_files_menu_page');
add_action('admin_menu', 'wm_add_settings_page');
add_action('admin_init', 'wm_register_settings');
add_action('wpcf7_before_send_mail', 'wm_on_before_cf7_send_mail');
