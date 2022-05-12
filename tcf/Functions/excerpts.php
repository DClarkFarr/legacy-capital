<?php

namespace Excerpts;

function the_custom_excerpt($limit = 50, $post_id = null)
{
    return esc_html(get_the_custom_excerpt($limit, $post_id = null));
}
function get_the_custom_excerpt($limit = 75, $post_id = null)
{
    if (!$post_id) {
        global $post;
        $post_id = $post->ID;
    }
    if (has_excerpt($post_id)) {
        return get_the_excerpt($post_id);
    }

    $excerpt = strip_tags(get_the_content(null, false, $post_id));
    $words = explode(' ', $excerpt);
    $words = array_filter($words);
    if (count($words) > $limit) {
        $words = array_slice($words, 0, $limit);
        $words[] = '...';
    }

    return implode(' ', $words);
}
