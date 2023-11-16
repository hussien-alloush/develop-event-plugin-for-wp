<?php
/**
 * plugin name: events plugin
 * description: simple events form plugin
 * author: hussien alloush
 * version: 1.0.0
 */

 if(!defined("ABSPATH")){
    echo "what are you trying to do!";
    exit();
 }
 // Register Custom Post Type
function create_events_post_type() {
    register_post_type('events',
        array(
            'labels' => array(
                'name' => __('Events'),
                'singular_name' => __('Event'),
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        )
    );
}
add_action('init', 'create_events_post_type');

// Register Custom Taxonomy
function create_events_taxonomy() {
    register_taxonomy(
        'event_category',
        'events',
        array(
            'label' => __('Event Categories'),
            'hierarchical' => true,
        )
    );
}
add_action('init', 'create_events_taxonomy');

// Shortcode to Display Events
function events_shortcode() {
    $args = array(
        'post_type' => 'events',
        'posts_per_page' => -1,
    );

    $events_query = new WP_Query($args);

    if ($events_query->have_posts()) {
        $output = '<ul>';
        while ($events_query->have_posts()) {
            $events_query->the_post();
            $output .= '<li>';
            $output .= '<h2>' . get_the_title() . '</h2>';
            $output .= '<div>' . get_the_content() . '</div>';
            $output .= '<p>Date: ' . get_post_meta(get_the_ID(), 'date', true) . '</p>';
            $output .= '</li>';
        }
        $output .= '</ul>';
    } else {
        $output = '<p>No events found</p>';
    }

    wp_reset_postdata();

    return $output;
}
add_shortcode('events_list', 'events_shortcode');


