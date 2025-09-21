<?php
/**
 * Fired during plugin deactivation
 *
 * @package Community_First_Construction_Essentials
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Community_First_Construction_Essentials_Deactivator {
    /**
     * Run tasks on plugin deactivation.
     *
     * @return void
     */
    public static function deactivate() {
        // Flush rewrite rules if you registered CPTs/taxonomies.
        if ( function_exists( 'flush_rewrite_rules' ) ) {
            flush_rewrite_rules();
        }
    }
}
