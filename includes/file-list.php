<?php


function wm_render_stored_files_page() {

    $storage_directory = wm_get_storage_directory();
    

    $files = wm_get_files_list($storage_directory);


    $storage_type = get_option('wm_secure_mode', false) ? 'Secure Storage' : 'WP Content Uploads';

    ?>
    <div class="wrap">
        <h1>Stored Files (<?php echo $storage_type; ?>)</h1>
        <table class="widefat fixed" cellspacing="0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date Modified</th>
                    <th>Size (bytes)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($files)): ?>
                    <?php foreach ($files as $file): ?>
                        <?php if (strpos($file['name'], '.htaccess') === false): // Verstecke .htaccess ?>
                            <tr>
                                <td><?php echo $file['name']; ?></td>
                                <td><?php echo date('Y-m-d H:i:s', $file['last_modified']); ?></td>
                                <td><?php echo $file['size']; ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No files found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}
