<?php

class PartsType{
    public function __construct(){
        add_action('init', [$this, 'oleksaskillup_register_post_types']);
    }

    function oleksaskillup_register_post_types()
    {
        register_post_type('parts', [
            'labels' => [
                'name'               => _x('Parts', 'Admin Part', 'oleksaskillup'),
                'singular_name'      => _x('Part', 'Admin Part', 'oleksaskillup'),
                'menu_name'          => _x('Parts', 'Admin Part', 'oleksaskillup'),
                'all_items'          => _x('All Parts', 'Admin Part', 'oleksaskillup'),
                'add_new'            => _x('Add New', 'Admin Part', 'oleksaskillup'),
                'add_new_item'       => _x('Add Part', 'Admin Part', 'oleksaskillup'),
                'edit'               => _x('Edit', 'Admin Part', 'oleksaskillup'),
                'edit_item'          => _x('Edit Part', 'Admin Part', 'oleksaskillup'),
                'new_item'           => _x('New Part', 'Admin Part', 'oleksaskillup'),
                'view'               => _x('View Part', 'Admin Part', 'oleksaskillup'),
                'view_item'          => _x('View Part', 'Admin Part', 'oleksaskillup'),
                'search_items'       => _x('Search Part', 'Admin Part', 'oleksaskillup'),
                'not_found'          => _x('Part not found', 'Admin Part', 'oleksaskillup'),
                'not_found_in_trash' => _x('Parts nor fount in trash', 'Admin Part', 'oleksaskillup'),
                'parent'             => _x('Parent Part', 'Admin Part', 'oleksaskillup'),
            ],
            'rewrite' => [
                'slug'       => 'parts',

            ],
            'description'         => '',
            'public'              => true,
            'show_ui'             => true,
            'capability_type'     => 'page',
            'map_meta_cap'        => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'hierarchical'        => false,
            'query_var'           => true,
            'show_in_rest' => true,

            'supports'            => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
            'menu_position'       => 3,
            'has_archive'         => true,
            'show_in_nav_menus'   => true,


        ]);

        register_taxonomy('parts_category', ['parts'], [
            'labels' => [
                'name'              => _x('Categories', 'Admin category', 'oleksaskillup'),
                'singular_name'     => _x('Category', 'Admin category', 'oleksaskillup'),
                'menu_name'         => _x('Categories', 'Admin category', 'oleksaskillup'),
                'search_items'      => _x('Search Category', 'Admin category', 'oleksaskillup'),
                'all_items'         => _x('All Categories', 'Admin category', 'oleksaskillup'),
                'parent_item'       => _x('Parent Category', 'Admin category', 'oleksaskillup'),
                'parent_item_colon' => _x('Parent Category:', 'Admin category', 'oleksaskillup'),
                'edit_item'         => _x('Edit Category', 'Admin category', 'oleksaskillup'),
                'update_item'       => _x('Update Category', 'Admin category', 'oleksaskillup'),
                'add_new_item'      => _x('Add New Category', 'Admin category', 'oleksaskillup'),
                'new_item_name'     => _x('New Category Name', 'Admin category', 'oleksaskillup'),
            ],
            'public'                => true,
            'show_in_rest' => true,
            'hierarchical'          => true,
            'update_count_callback' => '_update_post_term_count',
            //  'rewrite' => ['slug' => 'parts_category'],
            'meta_box_cb' => 'post_categories_meta_box',
            'show_admin_column' => true

        ]);

        register_taxonomy('parts_tags', ['parts'], [
            'labels' => [
                'name'              => _x('Tags', 'Admin tag', 'oleksaskillup'),
                'singular_name'     => _x('Tag', 'Admin tag', 'oleksaskillup'),
                'menu_name'         => _x('Tags', 'Admin tag', 'oleksaskillup'),
                'search_items'      => _x('Search Tags', 'Admin tag', 'oleksaskillup'),
                'all_items'         => _x('All Pags', 'Admin tag', 'oleksaskillup'),
                'parent_item'       => _x('Parent Tags', 'Admin tag', 'oleksaskillup'),
                'parent_item_colon' => _x('Pags', 'Admin tag', 'oleksaskillup'),
                'add_new_item'      => _x('Add new tag', 'Admin tag', 'oleksaskillup'),
                'new_item_name'     => _x('New Tag', 'Admin tag', 'oleksaskillup'),
            ],
            'public'                => true,
            'show_in_rest' => true,
            'hierarchical'          => true,
            'update_count_callback' => '_update_post_term_count',
            //      'rewrite' => ['slug' => 'parts_tags'],
            'meta_box_cb' => 'post_tags_meta_box',
            'show_admin_column' => true

        ]);
    }
}

new PartsType();

