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
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_public_assets' ], 100000 );

        // Admin assets placeholder.
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );

        // Register Gutenberg blocks bootstrap (to be implemented).
        add_action( 'init', [ $this, 'register_blocks' ] );

        // Load styles in the block editor (Gutenberg) as well.
        add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_editor_assets' ], 100000 );

        // Register Gutenberg editor color palette (override theme palette if needed).
        add_action( 'after_setup_theme', [ $this, 'register_editor_palette' ], 11 );
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
        wp_enqueue_style( 'cfce-public', CFCE_PLUGIN_URL . 'public/css/public.css', [], CFCE_VERSION );
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

    /**
     * Enqueue styles for the Gutenberg block editor so the editor matches frontend styles.
     */
    public function enqueue_block_editor_assets() {
        // Reuse the public stylesheet in the editor; depend on core editor styles to ensure proper load order.
        wp_enqueue_style( 'cfce-editor', CFCE_PLUGIN_URL . 'public/css/public.css', [ 'wp-edit-blocks' ], CFCE_VERSION );
        // Editor-only tweaks (does not load on frontend)
        wp_enqueue_style( 'cfce-editor-only', CFCE_PLUGIN_URL . 'public/css/editor.css', [ 'cfce-editor' ], CFCE_VERSION );
    }

    /**
     * Register a custom color palette for the block editor to match plugin/brand colors.
     */
    public function register_editor_palette() {
        // Works for classic themes without theme.json. Runs after the theme so we can override.
        add_theme_support( 'editor-color-palette', [
            [
                'name'  => __( 'Primary', 'community-first-construction-essentials' ),
                'slug'  => 'primary',
                'color' => '#F6912B',
            ],
            [
                'name'  => __( 'Secondary', 'community-first-construction-essentials' ),
                'slug'  => 'secondary',
                'color' => '#2660A4',
            ],
            [
                'name'  => __( 'Black', 'community-first-construction-essentials' ),
                'slug'  => 'black',
                'color' => '#221F1F',
            ],
            [
                'name'  => __( 'White', 'community-first-construction-essentials' ),
                'slug'  => 'white',
                'color' => '#F7FFF7',
            ],
            [
                'name'  => __( 'Accent', 'community-first-construction-essentials' ),
                'slug'  => 'accent',
                'color' => '#CE6A85',
            ],
        ] );

        // Optional: lock the palette so users can't pick arbitrary colors in the editor.
        // add_theme_support( 'disable-custom-colors' );
    }
}
