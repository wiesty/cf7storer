<?php


function wm_get_files_list($directory) {
    $files = array();
    
    if (is_dir($directory)) {
        $dir = opendir($directory);
        
        while (($file = readdir($dir)) !== false) {
            if ($file != '.' && $file != '..' && !is_dir($directory . '/' . $file)) {
                $file_path = $directory . '/' . $file;
                $files[] = array(
                    'name' => $file,
                    'path' => $file_path,
                    'size' => filesize($file_path),
                    'last_modified' => filemtime($file_path)
                );
            }
        }
        closedir($dir);
    }
    
    return $files;
}


function wm_delete_file($file_path) {
    if (file_exists($file_path)) {
        if (unlink($file_path)) {
            return true;
        }
    }
    return false;
}


function wm_get_storage_directory() {
    $secure_mode = get_option('wm_secure_mode', false);

    if ($secure_mode) {
        return get_option('wm_custom_upload_path', '');
    } else {
        $upload_dir = wp_upload_dir();
        return $upload_dir['basedir'] . '/cf7uploads';
    }
}


function wm_create_attachment($filename) {
    $store_files = get_option('wm_store_files', false);
    $secure_mode = get_option('wm_secure_mode', false);

    if ($store_files) {
        if ($secure_mode) {
            
            $custom_upload_dir = get_option('wm_custom_upload_path', '');

            
            if (!file_exists($custom_upload_dir)) {
                mkdir($custom_upload_dir, 0755, true);
            }

           
            $attachFileName = $custom_upload_dir . '/' . basename($filename);
        } else {
           
            $attachFileName = wm_handle_standard_upload($filename);
        }


        if (copy($filename, $attachFileName)) {
            return array('file_path' => $attachFileName, 'status' => 'success');
        } else {
            return array('status' => 'error', 'message' => 'File could not be copied.');
        }
    }
}


function wm_handle_standard_upload($filename) {
    $upload_dir = wp_upload_dir();
    $cf7uploads_dir = $upload_dir['basedir'] . '/cf7uploads';


    if (!file_exists($cf7uploads_dir)) {
        mkdir($cf7uploads_dir, 0755, true);
    }


    $htaccess_file = $cf7uploads_dir . '/.htaccess';
    if (!file_exists($htaccess_file)) {
        $htaccess_content = <<<EOT
Order Deny,Allow
Deny from all

<FilesMatch "\.(jpg|jpeg|png|gif|pdf)$">
    RewriteEngine On
    RewriteCond %{REQUEST_URI} ^/wp-admin/admin.php$
    RewriteCond %{QUERY_STRING} ^page=wm-stored-files&view_file=
    RewriteRule .* - [L]
</FilesMatch>
EOT;

        file_put_contents($htaccess_file, $htaccess_content);
    }

    $hashed_name = md5(basename($filename)) . '-' . time();
    $attachFileName = $cf7uploads_dir . '/' . $hashed_name . '.' . pathinfo($filename, PATHINFO_EXTENSION);

    return $attachFileName;
}



function wm_on_before_cf7_send_mail(\WPCF7_ContactForm $contactForm) {
    $submission = WPCF7_Submission::get_instance();
    if ($submission) {
        $uploaded_files = $submission->uploaded_files();
        if ($uploaded_files) {
            foreach ($uploaded_files as $fieldName => $filepath) {
                if (is_array($filepath)) {
                    foreach ($filepath as $key => $value) {
                        wm_create_attachment($value);
                    }
                } else {
                    wm_create_attachment($filepath);
                }
            }
        }
    }
}
