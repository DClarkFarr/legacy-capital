<?php

namespace Queries;

function get_post_id($post_id = null)
{
    if (!$post_id) {
        global $post;
        $post_id = $post->ID;
    }
    return $post_id;
}

function get_term_parents($term_id, $taxonomy = 'category', $args = [])
{
    $term = get_term($term_id, $taxonomy);

    if (is_wp_error($term)) {
        return $term;
    }

    if (!$term) {
        [];
    }

    $term_id = $term->term_id;

    $defaults = array(
        'format'    => 'name',
        'separator' => '/',
        'link'      => true,
        'inclusive' => true,
    );
    $args = wp_parse_args($args, $defaults);

    foreach (array('link', 'inclusive') as $bool) {
        $args[$bool] = wp_validate_boolean($args[$bool]);
    }

    return array_reverse(get_ancestors($term_id, $taxonomy, 'taxonomy'));
}

function getPostBySlug($slug, $post_type = 'post')
{
    global $post;

    $loop = new \WP_Query([
        'post_type' => $post_type,
        'name' => $slug,
        'limit' => 1,
    ]);

    $row = false;

    if ($loop->have_posts()) {
        $loop->the_post();
        $row = $post;
    }
    wp_reset_postdata();

    return $row;
}
