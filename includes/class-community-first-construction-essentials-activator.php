<?php
/**
 * Fired during plugin activation
 *
 * @package Community_First_Construction_Essentials
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Community_First_Construction_Essentials_Activator {
    /**
     * Run tasks on plugin activation.
     *
     * @return void
     */
    public static function activate() {
        // Example: create options, default settings, etc.
        if ( ! get_option( 'cfce_version' ) ) {
            add_option( 'cfce_version', CFCE_VERSION );
        } else {
            update_option( 'cfce_version', CFCE_VERSION );
        }

        // Flush rewrite rules if you register CPTs/taxonomies later.
        if ( function_exists( 'flush_rewrite_rules' ) ) {
            flush_rewrite_rules();
        }
    }
}
