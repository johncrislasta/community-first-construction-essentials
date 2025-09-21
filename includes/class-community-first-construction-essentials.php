<?php
/**
 * Core plugin class
 *
 * @package Community_First_Construction_Essentials
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Community_First_Construction_Essentials {

    /**
     * Hook everything.
     *
     * @return void
     */
    public function run() {
        // Load translations.
        add_action( 'init', [ $this, 'load_textdomain' ] );

        // Frontend assets placeholder.
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_public_assets' ] );

        // Admin assets placeholder.
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );

        // Register Gutenberg blocks bootstrap (to be implemented).
        add_action( 'init', [ $this, 'register_blocks' ] );
    }

    /**
     * Load plugin textdomain for translations.
     *
     * @return void
     */
    public function load_textdomain() {
        load_plugin_textdomain( 'community-first-construction-essentials', false, dirname( plugin_basename( __FILE__ ) ) . '/../languages' );
    }

    /**
     * Enqueue public-facing assets.
     */
    public function enqueue_public_assets() {
        // Example placeholder. Add actual assets when needed.
        // wp_enqueue_style( 'cfce-public', CFCE_PLUGIN_URL . 'public/css/public.css', [], CFCE_VERSION );
        // wp_enqueue_script( 'cfce-public', CFCE_PLUGIN_URL . 'public/js/public.js', [ 'wp-element' ], CFCE_VERSION, true );
    }

    /**
     * Enqueue admin assets.
     */
    public function enqueue_admin_assets() {
        // Example placeholder. Add actual assets when needed.
        // wp_enqueue_style( 'cfce-admin', CFCE_PLUGIN_URL . 'admin/css/admin.css', [], CFCE_VERSION );
        // wp_enqueue_script( 'cfce-admin', CFCE_PLUGIN_URL . 'admin/js/admin.js', [ 'wp-element' ], CFCE_VERSION, true );
    }

    /**
     * Register Gutenberg blocks.
     */
    public function register_blocks() {
        // Placeholder: We'll add block.json registration and build pipeline later.
        // Example: register_block_type( CFCE_PLUGIN_DIR . 'build/your-block' );
    }
}
