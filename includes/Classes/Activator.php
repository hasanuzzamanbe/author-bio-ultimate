<?php

namespace AuthorBio\Classes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Ajax Handler Class
 * @since 1.0.0
 */
class Activator
{
    public function migrateDatabases($network_wide = false)
    {
        global $wpdb;
        if ($network_wide) {
            // Retrieve all site IDs from this network (WordPress >= 4.6 provides easy to use functions for that).
            if (function_exists('get_sites') && function_exists('get_current_network_id')) {
                $site_ids = get_sites(array('fields' => 'ids', 'network_id' => get_current_network_id()));
            } else {
                $site_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs WHERE site_id = $wpdb->siteid;");
            }
            // Install the plugin for all these sites.
            foreach ($site_ids as $site_id) {
                switch_to_blog($site_id);
                $this->migrate();
                restore_current_blog();
            }
        } else {
            $this->migrate();
        }

    }

    private function migrate()
    {
        $this->createBookmarkTable();
    }

    public function createBookmarkTable()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'author_bio';
        $sql = "CREATE TABLE $table_name (
                                          `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                          `author_id` int(10) NULL,
                                          `author_name` varchar(255) COLLATE 'utf8mb4_general_ci' NULL,
                                          `author_email` varchar(255) COLLATE 'utf8mb4_general_ci' NULL,
                                          `author_fb` varchar(255) COLLATE 'utf8mb4_general_ci' NULL,
                                          `author_tw` varchar(255) COLLATE 'utf8mb4_general_ci' NULL,
                                          `author_ln` varchar(255) COLLATE 'utf8mb4_general_ci' NULL,
                                          `author_ins` varchar(255) COLLATE 'utf8mb4_general_ci' NULL,
                                          `author_img` varchar(255) COLLATE 'utf8mb4_general_ci' NULL,
                                          `author_gravatar` varchar(255) COLLATE 'utf8mb4_general_ci' NULL,
                                          `author_designation` varchar(255) COLLATE 'utf8mb4_general_ci' NULL,
                                          `useBioFrom` varchar(255) COLLATE 'utf8mb4_general_ci' NULL
                                        ) $charset_collate;";

        $this->runSQL($sql, $table_name);
    }

    private function runSQL($sql, $tableName)
    {
        global $wpdb;
        if ($wpdb->get_var("SHOW TABLES LIKE '$tableName'") != $tableName) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }
}
