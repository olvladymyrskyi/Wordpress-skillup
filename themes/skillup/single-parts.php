<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package yaga
 */

get_header();
?>

    <main id="primary" class="site-main">

        <?php
        while ( have_posts() ) :
            the_post();

            get_template_part( 'template-parts/content-single-parts', '', array(
                'likes'	=> array(
                    'like' =>   $like->display_post_likes( get_the_ID() ),
                    'dislike' => $like->display_post_dislikes( get_the_ID() )

                )
            ));
        ?>

        <?php
            the_post_navigation(
                array(
                    'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'yaga' ) . '</span> <span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'yaga' ) . '</span> <span class="nav-title">%title</span>',
                )
            );


        endwhile; // End of the loop.
        ?>


    </main><!-- #main -->


    <div class="latest-posts">
        <?php echo get_last_parts(); ?>
    </div>

<?php

get_footer();
