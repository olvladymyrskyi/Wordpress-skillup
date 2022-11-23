<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header alignwide">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        the_content();

        ?>
    </div><!-- .entry-content -->

<?php

get_template_part( 'template-parts/likes', '', $args); ?>
</article><!-- #post-<?php the_ID(); ?> -->
