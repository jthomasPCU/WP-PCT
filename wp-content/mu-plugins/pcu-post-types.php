<?php
// Add featured images and excerpt to the Social Posts (Custom post type) to use with Zapier and IG
add_theme_support('post-thumbnails');

add_action('init', 'setup_types');

function setup_types() {
// Social Posts
    register_post_type('social', array(
        'show_in_rest'=> true,
        'public'    => true,
        'show_ui' => true,
        'labels'    => array (
            'name'  => 'Social Posts',
            'add_new_item' => 'Add New Social Post',
            'edit_item' => 'Edit Social Posts',
            'all_items' => 'All Social Posts',
            'singular_name' => "Social"
        ),
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        'menu_icon' => 'dashicons-instagram'
    ));

// Faqs
register_post_type('faq', array(
    'show_in_rest'=> true,
    'public'    => true,
    'show_ui' => true,
    'labels'    => array (
        'name'  => 'FAQs',
        'add_new_item' => 'Add New Faq',
        'edit_item' => 'Edit Faqs',
        'all_items' => 'All Faqs',
        'singular_name' => "Faq"
    ),
    'supports' => array('title', 'editor'),
    'menu_icon' => 'dashicons-editor-help'
));

// Glossary Faqs
register_post_type('glossary', array(
    'show_in_rest'=> true,
    'public'    => true,
    'show_ui' => true,
    'labels'    => array (
        'name'  => 'Glossary FAQs',
        'add_new_item' => 'Add New Glossary Faq',
        'edit_item' => 'Edit Glossary Faqs',
        'all_items' => 'All Glossary Faqs',
        'singular_name' => "Glossary Faq"
    ),
    'supports' => array('title','editor'),
    'menu_icon' => 'dashicons-editor-help'
));

}
?>