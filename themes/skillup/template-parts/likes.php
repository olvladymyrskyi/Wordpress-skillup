
<div class="post-meta-likes">
    <a href="#" class="my-post-like like-action" data-id="<?php the_ID(); ?>" data-status="parts_like">
        <span class="like-count"><?php echo $args['likes']['like']; ?> </span>
        <span class="dashicons dashicons-thumbs-up"></span>
    </a>
    <a href="#" class="my-post-dislike like-action" data-id="<?php the_ID(); ?>" data-status="parts_dislike">
        <span class="dislike-count"><?php echo $args['likes']['like']; ?> </span>
        <span class="dashicons dashicons-thumbs-down"></span>
    </a>

    <script type="text/javascript">
        (function( $ ) {
            $(function() {
                if( $( ".like-action" ).length ) {
                    $( ".like-action" ).partsLikes();
                }
            });
        })( jQuery );
    </script>
</div>
