<?php

class Like
{

    public function __construct()
    {
        add_action( 'wp_enqueue_scripts', [$this, 'parts_likes_jquery_scripts'] );
        add_action( 'wp_ajax_parts_likes', [$this, 'update_likes_count'] );
        add_action( 'wp_ajax_nopriv_parts_likes', [$this, 'update_likes_count'] );
        add_action( 'init', [$this, 'parts_likes_rewrites_init'] );
        add_filter( 'query_vars', [$this, 'parts_likes_query_vars'] );
        add_action( 'template_include',[$this, 'parts_likes_include_template']);
    }

    function parts_likes_include_template( $template ) {
        global $wp_query;

        if ( get_query_var( 'pagename' ) == false || get_query_var( 'pagename' ) != 'likes' ) {
            return $template;
        }

        return get_theme_file_path() . '/all-likes.php';
    }

    function parts_likes_rewrites_init(){
       // add_rewrite_rule( 'likes/([a-z]+)[/]?$', 'index.php?likes=$matches[1]', 'top' );
        add_rewrite_rule(
            'likes',
            'index.php?pagename=likes',
            'top' );
    }

    function parts_likes_query_vars( $query_vars ){
        $query_vars[] = 'likes';
        return $query_vars;
    }

    function parts_likes_jquery_scripts() {

        wp_register_script( 'parts_likes', get_template_directory_uri() . '/assets/js/parts-likes.js', array( 'jquery' ), time(), true );
        wp_enqueue_script( 'parts_likes' );
        wp_localize_script( 'parts_likes', 'parts_likes', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    }

    function update_likes_count() {

        $post_id = intval( $_GET['post_id'] );
        $count = 0;

        if( filter_var( $post_id, FILTER_VALIDATE_INT ) ) {

            $article = get_post( $post_id );

            $count_like = ( get_post_meta( $post_id, 'my-post-likes', true ))?: 0;
            $count_dislike = (get_post_meta( $post_id, 'my-post-dislikes', true ))?: 0;

            if( !is_null( $article ) && ($_GET['status'] == 'parts_like')) {

                if( $count_like == '' ) {
                    update_post_meta( $post_id, 'my-post-likes', '1' );
                    $count = 1;
                } else {
                    $n = intval( $count_like);
                    $n++;
                    update_post_meta( $post_id, 'my-post-likes', $n );
                    $count = $n;
                }
            }

            if( !is_null( $article ) && ($_GET['status'] == 'parts_dislike')) {
                if( $count_dislike == '' ) {
                    update_post_meta( $post_id, 'my-post-dislikes', '1' );
                    $count = 1;
                } else {
                    $n = intval( $count_dislike );
                    $n++;
                    update_post_meta( $post_id, 'my-post-dislikes', $n );
                    $count = $n;
                }
            }
        }
        $output = array( 'count' => $count);
        echo json_encode( $output );
        exit();
    }

    function get_posts_with_likes_dislikes( $type = 'post', $status = 'publish' ) {

        $args = array(
            'posts_per_page'   => -1,
            'post_type' => $type,
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_status'      => $status,
            'meta_query' => array(
                array(
                    'key'     => 'my-post-likes'
                ),
                array(
                    'key'     => 'my-post-dislikes'
                ),
            ),
        );

        return get_posts( $args );
    }

    function display_post_likes( $post_id = null ) {

        $value = '';
        if( is_null( $post_id ) ) {
            global $post;
            $value = get_post_meta( $post->ID, 'my-post-likes', true );

        } else {
            $value = get_post_meta( $post_id, 'my-post-likes', true );
        }

        return $value;
    }

    function display_post_dislikes( $post_id = null ) {
        $value = '';
        if( is_null( $post_id ) ) {
            global $post;
            $value = get_post_meta( $post->ID, 'my-post-dislikes', true );

        } else {
            $value = get_post_meta( $post_id, 'my-post-dislikes', true );
        }

        return $value;
    }


}

$like = new Like();
