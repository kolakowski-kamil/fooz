<?php


add_action('wp_enqueue_scripts', 'childtheme_enqueue_assets');
function childtheme_enqueue_assets()
{
    $theme_uri = get_stylesheet_directory_uri();

    // CSS
    wp_enqueue_style(
        'child-styles',
        "{$theme_uri}/assets/css/styles.css",
        [],
        filemtime(__DIR__ . "/assets/css/styles.css")
    );

    // JS
    wp_enqueue_script(
        'child-scripts',
        "{$theme_uri}/assets/js/scripts.js",
        ['jquery'],
        filemtime(__DIR__ . "/assets/js/scripts.js"),
        true
    );
}




// Books CPT
add_action('init', 'childtheme_register_books_cpt');
function childtheme_register_books_cpt()
{
    $labels = [
        'name'               => __('Books', 'twentytwentyfive-child'),
        'singular_name'      => __('Book',  'twentytwentyfive-child'),
        'add_new_item'       => __('Add New Book', 'twentytwentyfive-child'),
        'edit_item'          => __('Edit Book',    'twentytwentyfive-child'),
        'new_item'           => __('New Book',     'twentytwentyfive-child'),
        'view_item'          => __('View Book',    'twentytwentyfive-child'),
        'search_items'       => __('Search Books', 'twentytwentyfive-child'),
        'not_found'          => __('No books found', 'twentytwentyfive-child'),
        'not_found_in_trash' => __('No books in trash', 'twentytwentyfive-child'),
        'all_items'          => __('All Books',    'twentytwentyfive-child'),
        'archives'           => __('Book Archives', 'twentytwentyfive-child'),
        'menu_name'          => __('Books',        'twentytwentyfive-child'),
    ];

    register_post_type('books', [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'library'],
        'show_in_rest'       => true,
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-book-alt',
    ]);

    $tax_labels = [
        'name'              => __('Genres',      'twentytwentyfive-child'),
        'singular_name'     => __('Genre',       'twentytwentyfive-child'),
        'search_items'      => __('Search Genres', 'twentytwentyfive-child'),
        'all_items'         => __('All Genres',  'twentytwentyfive-child'),
        'edit_item'         => __('Edit Genre',  'twentytwentyfive-child'),
        'update_item'       => __('Update Genre', 'twentytwentyfive-child'),
        'add_new_item'      => __('Add New Genre', 'twentytwentyfive-child'),
        'new_item_name'     => __('New Genre Name', 'twentytwentyfive-child'),
        'menu_name'         => __('Genre',       'twentytwentyfive-child'),
    ];

    register_taxonomy('book-genre', 'books', [
        'labels'            => $tax_labels,
        'public'            => true,
        'hierarchical'      => true,
        'rewrite'           => ['slug' => 'book-genre'],
        'show_in_rest'      => true,
    ]);
}




// Books AJAX
add_action('wp_head', function () {
    if (is_singular('books')) {
        echo '<script>document.addEventListener("DOMContentLoaded",function(){document.body.dataset.postId = ' . get_the_ID() . ';});</script>';
    }
});
add_action('wp_ajax_get_other_books', 'twentyfive_child_get_other_books');
add_action('wp_ajax_nopriv_get_other_books', 'twentyfive_child_get_other_books');

function twentyfive_child_get_other_books()
{
    $excluded_id = isset($_GET['exclude']) ? intval($_GET['exclude']) : 0;

    $args = array(
        'post_type' => 'books',
        'posts_per_page' => 20,
        'post__not_in' => [$excluded_id],
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $query = new WP_Query($args);
    $results = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $genres = get_the_terms(get_the_ID(), 'book-genre');
            $results[] = [
                'title' => get_the_title(),
                'date' => get_the_date(),
                'genre' => $genres ? wp_list_pluck($genres, 'name') : [],
                'excerpt' => get_the_excerpt(),
            ];
        }
    }
    wp_reset_postdata();

    wp_send_json($results);
}




// FAQ Block
add_action('acf/init', function () {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'faq-accordion',
            'title'             => __('FAQ Accordion', 'twentytwentyfive-child'),
            'description'       => __('FAQ section with an accordion of questions and answers.', 'twentytwentyfive-child'),
            'render_template'   => get_stylesheet_directory() . '/blocks/faq-accordion/faq-accordion.php',
            'category'          => 'widgets',
            'icon'              => 'editor-help',
            'keywords'          => array('faq', 'accordion', 'pytania'),
            'mode'              => 'preview',
            'supports'          => array(
                'align'      => false,
                'anchor'     => true,
                'jsx'        => true,
            ),
            'enqueue_assets'    => function () {
                wp_enqueue_script(
                    'faq-accordion-script',
                    get_stylesheet_directory_uri() . '/assets/js/faq-accordion.js',
                    array(),
                    null,
                    true
                );
                wp_enqueue_style(
                    'faq-accordion-style',
                    get_stylesheet_directory_uri() . '/assets/css/faq-accordion.css',
                    array(),
                    null
                );
            }
        ));
    }

    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_faq_accordion',
            'title' => 'FAQ Accordion',
            'fields' => array(
                array(
                    'key' => 'field_faq_heading',
                    'label' => 'Section header',
                    'name' => 'faq_heading',
                    'type' => 'text',
                    'default_value' => 'Frequently Asked Questions',
                ),
                array(
                    'key' => 'field_faq_icon_style',
                    'label' => 'Icon Style',
                    'name' => 'icon_style',
                    'type' => 'select',
                    'choices' => array(
                        'plus_minus' => 'Plus / Minus',
                        'up_down'     => 'Up / Down',
                    ),
                    'default_value' => 'plus_minus',
                    'ui'            => 1,
                    'return_format' => 'value',
                    'wrapper'       => array('width' => '50'),
                ),
                array(
                    'key' => 'field_faq_items',
                    'label' => 'FAQ Items',
                    'name' => 'faq_items',
                    'type' => 'repeater',
                    'min' => 1,
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_faq_question',
                            'label' => 'Question',
                            'name' => 'question',
                            'type' => 'text',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'field_faq_answer',
                            'label' => 'Answer',
                            'name' => 'answer',
                            'type' => 'wysiwyg',
                            'required' => 1,
                            'tabs' => 'all',
                            'toolbar' => 'full',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/faq-accordion',
                    ),
                ),
            ),
        ));
    }
});
