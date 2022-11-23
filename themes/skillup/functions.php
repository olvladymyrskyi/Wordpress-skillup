<?php

require get_template_directory() . '/inc/theme.php';
require get_template_directory() . '/inc/partsType.php';
require get_template_directory() . '/inc/metaboxes/color-parts-metabox.php';
require get_template_directory() . '/inc/metaboxes/brand-parts-metabox.php';
require get_template_directory() . '/inc/metaboxes/image-parts-metabox.php';

require get_template_directory() . '/inc/template-tags.php';

// Handle SVG icons.
require get_template_directory() . '/classes/class-oleksaskillup-svg-icons.php';
require get_template_directory() . '/inc/svg-icons.php';

// Handle Customizer settings.
require get_template_directory() . '/classes/class-oleksaskillup-customize.php';

// Require Separator Control class.
require get_template_directory() . '/classes/class-oleksaskillup-separator-control.php';

// Custom comment walker.
require get_template_directory() . '/classes/class-oleksaskillup-walker-comment.php';

// Custom page walker.
require get_template_directory() . '/classes/class-oleksaskillup-walker-page.php';

// Custom script loader class.
require get_template_directory() . '/classes/class-oleksaskillup-script-loader.php';

// Block Patterns.
require get_template_directory() . '/inc/block-patterns.php';

// Parts Filter
require get_template_directory() . '/inc/filters/renderer.php';

require  get_template_directory() . '/inc/likes/like.php';
