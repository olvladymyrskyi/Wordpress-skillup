<?php

class Renderer{

    public function __construct(){
        add_action('add_parts_filters_skillup', [$this, 'add_parts_filters_skillup_function']);
        add_action( 'wp_enqueue_scripts', [$this, 'parts_filter_jquery_scripts'] );
        add_action( 'wp_ajax_parts_filter', [$this, 'ajax_parts_filter_function'] );
        add_action( 'wp_ajax_nopriv_parts_filter', [$this, 'ajax_parts_filter_function'] );
    }

    function add_parts_filters_skillup_function(){

        echo $this->get_filter_by_taxonomy_links( 'parts_category', 'By category:', '', 'AND' );
        echo $this->get_filter_by_color('color_color', 'By color');
        echo $this->get_filter_sort();

    }
    function get_filter_by_taxonomy_links($taxonomy = '', $title = '', $class = '', $query_type = 'AND')
    {
        global $wp_query, $wpdb;
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false
        ]);
        ?>
        <div class="collapse navbar-collapse filter-wrap">
            <h4><?php echo $title; ?></h4>
            <input type="hidden" class="filter-holder" name="filter-cat">
            <ul class="nav navbar-nav over inner maso-filters">
                <?php foreach($terms as $term) : ?>
                    <li class="current">
                        <a class="filter-item"
                           href="<?php echo get_term_link($term->term_id); ?>"
                           data-value="<?php echo $term->slug ?>">
                            <?php echo $term->name ?>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
        <?php
    }

    function get_filter_by_color($meta_key = '', $title = '')
    {
        global $wp_query, $wpdb;

        $colors = $this->get_meta_values($meta_key, 'parts', 'publish');
        ?>
        <div class="collapse navbar-collapse filter-wrap">
            <h4><?php echo $title; ?></h4>
            <input type="hidden" class="filter-holder" name="filter-color">
            <ul class="nav navbar-nav over inner maso-filters filter-color ">
                <?php foreach($colors as $color) : ?>
                    <li class="current">
                        <a class="filter-item"
                           href="#"
                           data-value="<?php echo $color ?>"
                           data-color="<?php echo $color ?>"
                           style="background-color: <?php echo $color; ?>" >
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
        <?php
    }

    function get_filter_sort(){
        ?>
        <div class="collapse navbar-collapse">
            <h4><?php echo __('Sort '); ?></h4>
            <input type="hidden" class="filter-holder" name="filter-sort">
            <ul class="nav navbar-nav over inner filter-sort ">
                <li class="asc">
                    <a  href="?post_type=parts&order=ASC"
                        data-filter-name="order"
                        data-filter-slug="asc"
                    >ASC</a>
                </li>
                <li class="desc">
                    <a  href="?post_type=parts&order=DESC"
                        data-filter-name="order"
                        data-filter-slug="asc"
                    >DESC</a>
                </li>
            </ul>
        </div>
        <?php
    }

    function parts_filter_jquery_scripts() {

        wp_register_script( 'parts_filter', get_template_directory_uri() . '/assets/js/parts-filter.js', array( 'jquery' ), time(), true );
        wp_enqueue_script( 'parts_filter' );
        wp_localize_script( 'parts_filter', 'parts_obj', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    }

    function ajax_parts_filter_function(){

        $args = array();

        $args[ 'post_type'] = 'parts';
        if(  $_POST[ 'filter-cat' ] ) {
            $args[ 'tax_query' ] = array(
                array(
                    'taxonomy' => 'parts_category',
                    'field' => 'slug',
                    'terms' => $_POST[ 'filter-cat' ]
                )
            );
        }

        if(  $_POST[ 'filter-color' ] ) {
            $args[ 'meta_query' ][] = array(
                'key' => 'color_color',
                'value' => $_POST[ 'filter-color' ],

            );

        }


       $res = query_posts( $args );

        if ( have_posts() ) {
            while ( have_posts() ) : the_post();
                echo '<div class="entry-content">';
                echo '  <a href="' . get_permalink() . '">' . get_the_title() . '</a>';
                echo '</div>';
            endwhile;

        } else {
            echo __('nothing found');
        }

        die();
    }

    function get_meta_values( $key = '', $type = 'post', $status = 'publish' ) {

        global $wpdb;

        if( empty( $key ) )
            return;

        $r = $wpdb->get_col( $wpdb->prepare( "
        SELECT pm.meta_value FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = %s
        AND p.post_status = %s
        AND p.post_type = %s
    ", $key, $status, $type ) );

        return $r;
    }

}

new Renderer();
