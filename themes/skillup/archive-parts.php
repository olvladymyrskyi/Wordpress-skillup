<?php

get_header();
?>
<div class="filter-container">
    <div class="filters">
        <form  method="POST" id="parts-filters">
            <input type="hidden" name="action" value="parts_filter">
            <?php do_action('add_parts_filters_skillup'); ?>
        </form>
    </div>
    <div id="filter-results" class="filter-results">
    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
        <div class="entry-content">
            <a href="<?php  the_permalink()  ?>"><?php echo  the_title() ?></a>
        </div>
    <?php endwhile; endif; ?>
    </div>
</div>
<?php
get_footer();

