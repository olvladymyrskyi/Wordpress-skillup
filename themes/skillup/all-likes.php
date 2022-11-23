<?php
get_header();
?>

    <main id="primary" class="site-main">
        <h1>ALL LIKES PAGE</h1>
<?php
$posts = $like->get_posts_with_likes_dislikes('parts', 'publish');

if( ! empty( $posts ) ){
?>
    <ul>
    <?php foreach ( $posts as $p ){ ?>
        <li><a href="<?php echo get_permalink( $p->ID ) ?>">
           <?php  echo $p->post_title ?></a></li>
    <?php } ?>
    </ul>
<?php } ?>


    </main><!-- #main -->


<?php

get_footer();
