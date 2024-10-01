
# CF7Storer – Securely Store Files from Contact Form 7

**Version**: 2.6.0  
**Author**: Wiestyy

CF7Storer is a WordPress plugin that securely stores files uploaded via the Contact Form 7 plugin. It provides flexible storage options with security measures to ensure files are only accessible by administrators and not publicly available.

## Features

-   **File Storage Options**:
    
    -   Store files uploaded through Contact Form 7 either in the default WordPress upload directory (`wp-content/uploads/cf7uploads`) or in a custom path outside the web root.
    -   Option to hash filenames when stored in the default upload directory for additional security.
-   **Secure Mode**:
    
    -   When enabled, files are stored in a custom directory outside the web-accessible path, allowing for more secure storage.
    -   When disabled, files are stored in a hashed format in `wp-content/uploads/cf7uploads` with automatic `.htaccess` file creation to block direct access.
-   **Admin-Only Access**:
    
    -   The plugin ensures that files are only accessible by administrators through the WordPress admin dashboard.
    -   Public access to stored files is blocked, and direct URLs to files are denied using `.htaccess` rules.
-   **File List in Admin Dashboard**:
    
    -   View all uploaded files within the WordPress admin area.
    -   Displays file name, upload date, and file size.
    -   `.htaccess` files are hidden from the list to prevent accidental modification.

## How It Works

1.  **File Storage**: Files uploaded through Contact Form 7 are automatically stored in either:
    
    -   The default WordPress upload directory (`wp-content/uploads/cf7uploads`), or
    -   A custom directory set by the administrator (in Secure Mode).
2.  **Secure File Access**: Files are protected by a `.htaccess` file that prevents public access. Only logged-in administrators can see the files through the admin dashboard.
    
3.  **Admin Dashboard View**: Administrators can see a table of stored files with the following details:
    
    -   File Name
    -   Date of Last Modification
    -   File Size

## How to Use

1.  Install and activate the plugin.
2.  Navigate to **Settings > CF7Storer** to configure the file storage settings:
    -   Enable file storage.
    -   Optionally enable **Secure Mode** to store files in a directory outside the web root.
3.  To view uploaded files, go to **Stored Files** in the admin menu, where you can see a list of uploaded files and their details.

## Security Features

-   **Automatic `.htaccess` Generation**: For the default WordPress uploads directory, the plugin automatically generates a `.htaccess` file to deny all public access.
-   **Secure File Access**: Only administrators can access the files through the WordPress admin area. Public access is completely blocked.

## Requirements

-   WordPress 5.0 or higher
-   Contact Form 7 plugin
