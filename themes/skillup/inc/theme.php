<?php
class Theme{

    public function __construct(){
        add_action( 'after_setup_theme', [$this, 'oleksaskillup_theme_support'] );
        add_action( 'wp_enqueue_scripts', [$this, 'oleksaskillup_register_styles'] );
        add_action( 'wp_enqueue_scripts', [$this, 'oleksaskillup_register_scripts'] );
        add_action( 'init', [$this, 'oleksaskillup_menus'] );
        add_action( 'widgets_init', [$this,'oleksaskillup_sidebar_registration'] );
        add_action( 'wp_ajax_parts_filter', [$this, 'parts_filter_function'] );
        add_action( 'wp_ajax_nopriv_parts_filter', [$this, 'parts_filter_function'] );

    }

    function oleksaskillup_theme_support() {

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // Custom background color.
        add_theme_support(
            'custom-background',
            array(
                'default-color' => 'f5efe0',
            )
        );

        // Set content-width.
        global $content_width;
        if ( ! isset( $content_width ) ) {
            $content_width = 580;
        }


        add_theme_support( 'post-thumbnails' );

        // Set post thumbnail size.
        set_post_thumbnail_size( 1200, 9999 );

        // Add custom image size used in Cover Template.
        add_image_size( 'oleksaskillup-fullscreen', 1980, 9999 );

        // Custom logo.
        $logo_width  = 120;
        $logo_height = 90;

        // If the retina setting is active, double the recommended width and height.
        if ( get_theme_mod( 'retina_logo', false ) ) {
            $logo_width  = floor( $logo_width * 2 );
            $logo_height = floor( $logo_height * 2 );
        }

        add_theme_support(
            'custom-logo',
            array(
                'height'      => $logo_height,
                'width'       => $logo_width,
                'flex-height' => true,
                'flex-width'  => true,
            )
        );

        add_theme_support( 'title-tag' );

        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'script',
                'style',
                'navigation-widgets',
            )
        );


        load_theme_textdomain( 'oleksaskillup' );

        add_theme_support( 'align-wide' );

        add_theme_support( 'responsive-embeds' );


        if ( is_customize_preview() ) {
            require get_template_directory() . '/inc/starter-content.php';
            add_theme_support( 'starter-content', oleksaskillup_get_starter_content() );
        }

        add_theme_support( 'customize-selective-refresh-widgets' );

        $loader = new OleksaSkillup_Script_Loader();
        add_filter( 'script_loader_tag', array( $loader, 'filter_script_loader_tag' ), 10, 2 );

    }

    function oleksaskillup_register_styles() {

        $theme_version = wp_get_theme()->get( 'Version' );
        wp_enqueue_style( 'dashicons' );
        wp_enqueue_style( 'oleksaskillup-style', get_stylesheet_uri(), array(), $theme_version );
        wp_style_add_data( 'oleksaskillup-style', 'rtl', 'replace' );

        // Add print CSS.
        wp_enqueue_style( 'oleksaskillup-print-style', get_template_directory_uri() . '/print.css', null, $theme_version, 'print' );

        wp_enqueue_style( 'oleksaskillup-style-bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css' );
        wp_enqueue_style( 'oleksaskillup-style-bootstrap-theme', get_template_directory_uri() . '/css/bootstrap/bootstrap-grid.min.css' );
        wp_enqueue_script( 'oleksaskillup-bootstrap-script', get_template_directory_uri() . '/js/bootstrap/bootstrap.min.js', array(), true );
    }

    function oleksaskillup_register_scripts() {

        $theme_version = wp_get_theme()->get( 'Version' );

        if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        wp_enqueue_script( 'oleksaskillup-js', get_template_directory_uri() . '/assets/js/index.js', array(), $theme_version, false );
        wp_script_add_data( 'oleksaskillup-js', 'async', true );

    }

    function oleksaskillup_menus() {

        $locations = array(
            'primary'  => __( 'Desktop Horizontal Menu', 'oleksaskillup' ),
            'expanded' => __( 'Desktop Expanded Menu', 'oleksaskillup' ),
            'mobile'   => __( 'Mobile Menu', 'oleksaskillup' ),
            'footer'   => __( 'Footer Menu', 'oleksaskillup' ),
            'social'   => __( 'Social Menu', 'oleksaskillup' ),
        );

        register_nav_menus( $locations );
    }

    function oleksaskillup_sidebar_registration() {

        // Arguments used in all register_sidebar() calls.
        $shared_args = array(
            'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
            'after_title'   => '</h2>',
            'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
            'after_widget'  => '</div></div>',
        );

        // Footer #1.
        register_sidebar(
            array_merge(
                $shared_args,
                array(
                    'name'        => __( 'Footer #1', 'oleksaskillup' ),
                    'id'          => 'sidebar-1',
                    'description' => __( 'Widgets in this area will be displayed in the first column in the footer.', 'oleksaskillup' ),
                )
            )
        );

        // Footer #2.
        register_sidebar(
            array_merge(
                $shared_args,
                array(
                    'name'        => __( 'Footer #2', 'oleksaskillup' ),
                    'id'          => 'sidebar-2',
                    'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'oleksaskillup' ),
                )
            )
        );

    }

    function oleksaskillup_get_elements_array() {

        $elements = array(
            'content'       => array(
                'accent'     => array(
                    'color'            => array( '.color-accent', '.color-accent-hover:hover', '.color-accent-hover:focus', ':root .has-accent-color', '.has-drop-cap:not(:focus):first-letter', '.wp-block-button.is-style-outline', 'a' ),
                    'border-color'     => array( 'blockquote', '.border-color-accent', '.border-color-accent-hover:hover', '.border-color-accent-hover:focus' ),
                    'background-color' => array( 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file .wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.bg-accent', '.bg-accent-hover:hover', '.bg-accent-hover:focus', ':root .has-accent-background-color', '.comment-reply-link' ),
                    'fill'             => array( '.fill-children-accent', '.fill-children-accent *' ),
                ),
                'background' => array(
                    'color'            => array( ':root .has-background-color', 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.wp-block-button', '.comment-reply-link', '.has-background.has-primary-background-color:not(.has-text-color)', '.has-background.has-primary-background-color *:not(.has-text-color)', '.has-background.has-accent-background-color:not(.has-text-color)', '.has-background.has-accent-background-color *:not(.has-text-color)' ),
                    'background-color' => array( ':root .has-background-background-color' ),
                ),
                'text'       => array(
                    'color'            => array( 'body', '.entry-title a', ':root .has-primary-color' ),
                    'background-color' => array( ':root .has-primary-background-color' ),
                ),
                'secondary'  => array(
                    'color'            => array( 'cite', 'figcaption', '.wp-caption-text', '.post-meta', '.entry-content .wp-block-archives li', '.entry-content .wp-block-categories li', '.entry-content .wp-block-latest-posts li', '.wp-block-latest-comments__comment-date', '.wp-block-latest-posts__post-date', '.wp-block-embed figcaption', '.wp-block-image figcaption', '.wp-block-pullquote cite', '.comment-metadata', '.comment-respond .comment-notes', '.comment-respond .logged-in-as', '.pagination .dots', '.entry-content hr:not(.has-background)', 'hr.styled-separator', ':root .has-secondary-color' ),
                    'background-color' => array( ':root .has-secondary-background-color' ),
                ),
                'borders'    => array(
                    'border-color'        => array( 'pre', 'fieldset', 'input', 'textarea', 'table', 'table *', 'hr' ),
                    'background-color'    => array( 'caption', 'code', 'code', 'kbd', 'samp', '.wp-block-table.is-style-stripes tbody tr:nth-child(odd)', ':root .has-subtle-background-background-color' ),
                    'border-bottom-color' => array( '.wp-block-table.is-style-stripes' ),
                    'border-top-color'    => array( '.wp-block-latest-posts.is-grid li' ),
                    'color'               => array( ':root .has-subtle-background-color' ),
                ),
            ),
            'header-footer' => array(
                'accent'     => array(
                    'color'            => array( 'body:not(.overlay-header) .primary-menu > li > a', 'body:not(.overlay-header) .primary-menu > li > .icon', '.modal-menu a', '.footer-menu a, .footer-widgets a', '#site-footer .wp-block-button.is-style-outline', '.wp-block-pullquote:before', '.singular:not(.overlay-header) .entry-header a', '.archive-header a', '.header-footer-group .color-accent', '.header-footer-group .color-accent-hover:hover' ),
                    'background-color' => array( '.social-icons a', '#site-footer button:not(.toggle)', '#site-footer .button', '#site-footer .faux-button', '#site-footer .wp-block-button__link', '#site-footer .wp-block-file__button', '#site-footer input[type="button"]', '#site-footer input[type="reset"]', '#site-footer input[type="submit"]' ),
                ),
                'background' => array(
                    'color'            => array( '.social-icons a', 'body:not(.overlay-header) .primary-menu ul', '.header-footer-group button', '.header-footer-group .button', '.header-footer-group .faux-button', '.header-footer-group .wp-block-button:not(.is-style-outline) .wp-block-button__link', '.header-footer-group .wp-block-file__button', '.header-footer-group input[type="button"]', '.header-footer-group input[type="reset"]', '.header-footer-group input[type="submit"]' ),
                    'background-color' => array( '#site-header', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal', '.menu-modal-inner', '.search-modal-inner', '.archive-header', '.singular .entry-header', '.singular .featured-media:before', '.wp-block-pullquote:before' ),
                ),
                'text'       => array(
                    'color'               => array( '.header-footer-group', 'body:not(.overlay-header) #site-header .toggle', '.menu-modal .toggle' ),
                    'background-color'    => array( 'body:not(.overlay-header) .primary-menu ul' ),
                    'border-bottom-color' => array( 'body:not(.overlay-header) .primary-menu > li > ul:after' ),
                    'border-left-color'   => array( 'body:not(.overlay-header) .primary-menu ul ul:after' ),
                ),
                'secondary'  => array(
                    'color' => array( '.site-description', 'body:not(.overlay-header) .toggle-inner .toggle-text', '.widget .post-date', '.widget .rss-date', '.widget_archive li', '.widget_categories li', '.widget cite', '.widget_pages li', '.widget_meta li', '.widget_nav_menu li', '.powered-by-wordpress', '.to-the-top', '.singular .entry-header .post-meta', '.singular:not(.overlay-header) .entry-header .post-meta a' ),
                ),
                'borders'    => array(
                    'border-color'     => array( '.header-footer-group pre', '.header-footer-group fieldset', '.header-footer-group input', '.header-footer-group textarea', '.header-footer-group table', '.header-footer-group table *', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal nav *', '.footer-widgets-outer-wrapper', '.footer-top' ),
                    'background-color' => array( '.header-footer-group table caption', 'body:not(.overlay-header) .header-inner .toggle-wrapper::before' ),
                ),
            ),
        );

        return apply_filters( 'oleksaskillup_get_elements_array', $elements );
    }

}

new Theme();
