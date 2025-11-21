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

        // Register ACF field groups from JSON, then register ACF blocks when ACF initializes.
        add_action( 'acf/init', [ $this, 'register_acf_field_groups_from_json' ], 5 );
        add_action( 'acf/init', [ $this, 'register_acf_blocks' ], 10 );
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

        // Conditionally load Swiper + carousel init only if the Carousel block exists on the current page
        if ( $this->should_enqueue_carousel_assets() ) {
            wp_enqueue_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css', [], '12.0.2' );
            wp_enqueue_script( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js', [], '12.0.2', true );

            // Carousel init script
            wp_enqueue_script(
                'cfce-carousel',
                CFCE_PLUGIN_URL . 'blocks/carousel/scripts.js',
                [ 'swiper' ],
                CFCE_VERSION,
                true
            );

            wp_enqueue_style( 'cfce-carousel', CFCE_PLUGIN_URL . 'blocks/carousel/styles.css', [], CFCE_VERSION );
        }
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

        // Conditionally enqueue Swiper + init in editor if editing a post that has the carousel block
        if ( $this->should_enqueue_carousel_assets( true ) ) {
            wp_enqueue_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css', [], '12.0.2' );
            wp_enqueue_script( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js', [], '12.0.2', true );

            wp_enqueue_script(
                'cfce-carousel',
                CFCE_PLUGIN_URL . 'blocks/carousel/scripts.js',
                [ 'swiper' ],
                CFCE_VERSION,
                true
            );
        }
    }

    /**
     * Determine if we should enqueue carousel assets.
     * Frontend: true when viewing a singular post that contains the acf/carousel block.
     * Editor: attempts to check current post content; falls back to true in block editor preview iframe.
     *
     * @param bool $in_admin Whether this is called from editor assets hook.
     * @return bool
     */
    protected function should_enqueue_carousel_assets( $in_admin = false ) {
        // In REST block preview iframe, there might be no global post; allow enqueue to avoid missing assets
        if ( $in_admin ) {
            // Try to detect current post id from request
            $post_id = 0;
            if ( isset( $_GET['post'] ) ) {
                $post_id = (int) $_GET['post'];
            } elseif ( isset( $_POST['post_ID'] ) ) {
                $post_id = (int) $_POST['post_ID'];
            }
            if ( $post_id && function_exists( 'has_block' ) ) {
                return has_block( 'acf/carousel', $post_id );
            }
            // Fallback true to ensure editor previews work even when detection fails
            return true;
        }

        if ( ! function_exists( 'has_block' ) ) {
            return false;
        }

        if ( is_singular() ) {
            return has_block( 'acf/carousel', get_queried_object_id() );
        }

        return false;
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

    /**
     * Register ACF-based blocks.
     */
    public function register_acf_blocks() {
        if ( ! function_exists( 'acf_register_block_type' ) ) {
            return;
        }

        // Project Details block
        acf_register_block_type( [
            'name'            => 'project-details',
            'title'           => __( 'Project Details', 'community-first-construction-essentials' ),
            'description'     => __( 'Displays fields from the Project CPT.', 'community-first-construction-essentials' ),
            // Use a render callback so we can include a template from inside this plugin.
            'render_callback' => [ $this, 'render_project_details_block' ],
            'category'        => 'formatting',
            'icon'            => 'admin-home',
            'keywords'        => [ 'project', 'acf', 'details' ],
            'supports'        => [
                'align' => true,
            ],
        ] );

        
        acf_register_block_type(array(
            'name'              => 'key-figures',
            'title'             => __('Key Figures'),
            'description'       => __('Displays Key Figures chart and stats.'),
            'render_template'   => rtrim( CFCE_PLUGIN_DIR, '/' ) . '/template-parts/blocks/key-figures.php',
            'category'          => 'widgets',
            'icon'              => 'chart-bar',
            'keywords'          => array( 'figures', 'chart', 'progress' ),
            'mode'              => 'edit',
            'supports'          => array('align' => true),
        ));

        // Carousel block
        acf_register_block_type( [
            'name'            => 'carousel',
            'title'           => __( 'Carousel', 'community-first-construction-essentials' ),
            'description'     => __( 'Image carousel with configurable options (autoplay, delay, pagination, navigation, loop).', 'community-first-construction-essentials' ),
            'render_template' => rtrim( CFCE_PLUGIN_DIR, '/' ) . '/template-parts/blocks/carousel.php',
            'category'        => 'widgets',
            'icon'            => 'images-alt2',
            'keywords'        => [ 'carousel', 'slider', 'gallery' ],
            'mode'            => 'preview',
            'supports'        => [ 'align' => true ],
        ] );

    }

    /**
     * Load ACF Local Field Groups from JSON files in plugin blocks directory.
     * Looks for files at: CFCE_PLUGIN_DIR . 'blocks/<block-name>/fields.json'.
     * Each JSON may be a single group object or an array of group objects.
     */
    public function register_acf_field_groups_from_json() {
        if ( ! function_exists( 'acf_add_local_field_group' ) ) {
            return;
        }

        $blocks_dir = rtrim( CFCE_PLUGIN_DIR, '/' ) . '/blocks';
        if ( ! is_dir( $blocks_dir ) ) {
            return;
        }

        $directories = glob( $blocks_dir . '/*', GLOB_ONLYDIR );
        if ( ! $directories ) {
            return;
        }

        foreach ( $directories as $dir ) {
            $json_path = $dir . '/fields.json';
            if ( ! file_exists( $json_path ) ) {
                continue;
            }

            $raw = file_get_contents( $json_path );
            if ( false === $raw ) {
                continue;
            }

            $data = json_decode( $raw, true );
            if ( json_last_error() !== JSON_ERROR_NONE ) {
                continue;
            }

            // Allow a single object or an array of groups
            $groups = isset( $data[0] ) ? $data : [ $data ];
            foreach ( $groups as $group ) {
                if ( is_array( $group ) && isset( $group['key'] ) && isset( $group['fields'] ) ) {
                    acf_add_local_field_group( $group );
                }
            }
        }
    }

    /**
     * Render callback for the Project Details block.
     * Looks for a template at cfc/blocks/project-details.php inside this plugin.
     * If not found, outputs a helpful notice for admins.
     *
     * @param array      $block      Block settings and attributes.
     * @param string     $content    Block inner HTML (empty).
     * @param bool       $is_preview Whether or not the block is being rendered for editing preview.
     * @param int|string $post_id    The post ID the block is rendering content against.
     * @return void
     */
    public function render_project_details_block( $block, $content = '', $is_preview = false, $post_id = 0 ) {
        $template = rtrim( CFCE_PLUGIN_DIR, '/' ) . '/blocks/project-details.php';

        if ( file_exists( $template ) ) {
            include $template;
            return;
        }

        if ( current_user_can( 'edit_posts' ) ) {
            echo '<div class="notice notice-warning" style="padding:12px;border:1px solid #f0b849;background:#fffbe5;">';
            echo '<strong>Project Details block:</strong> Template not found.<br/>';
            echo 'Create: <code>' . esc_html( str_replace( ABSPATH, '', $template ) ) . '</code>.';
            echo '</div>';
        }
    }
}
