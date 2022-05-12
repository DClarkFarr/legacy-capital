<?php

namespace Components;

function tcf_pagination($path, $total, $current = 1)
{
    $path = strpos($path, '[i]') !== false ? $path : $path . '[i]';

    $html = '';
    $html .= '<nav aria-label="Pagination">';
    $html .= '<ul class="pagination">';
    if ($current - 3 > 0) {
        $min = 1;
        while ($min < $current - 3) {
            $link = str_replace('[i]', $min, $path);
            $html .= '<li class="page-item">';
            $html .= '<a class="page-link" data-i="' . $min . '" href="' . $link . '">';
            $html .= $min;
            $html .= '</a>';
            $html .= '</li>';
            $min += min(ceil(($current - $min) / 5), $current - 4);
        }
    }
    for ($i = max(1, $current - 3); $i < min($total + 1, $current + 4); $i++) {
        $link = str_replace('[i]', $i, $path);
        $html .= '<li class="page-item ' . ($i == $current ? 'active' : '') . '">';
        if ($current == $i) {
            $html .= '<span class="page-link">';
            $html .= $i;
            $html .= '</span>';
        } else {
            $html .= '<a class="page-link" data-i="' . $i . '" href="' . $link . '">';
            $html .= $i;
            $html .= '</a>';
        }
        $html .= '</li>';
    }

    if ($current + 3 < $total) {
        $max = $current + 4;
        while ($max < $total + 1) {
            $link = str_replace('[i]', $max, $path);
            $html .= '<li class="page-item">';
            $html .= '<a class="page-link" data-i="' . $max . '" href="' . $link . '">';
            $html .= $max;
            $html .= '</a>';
            $html .= '</li>';
            $max += min(ceil(($total - $max) / 5), $total);

            if ($max >= $total) {
                break;
            }
        }
    }
    $html .= '</ul>';
    $html .= '</nav>';

    return $html;
}

function breadcrumbs()
{
    $home      = __('Home'); // text for the 'Home' link
    $homeLink = home_url();

    $a = function ($href = '#', $text = "") {
        return '<a href="' . $href . '">' . $text . '</a>';
    };
    $li = function ($href, $text, $active = false) use ($a) {
        if ($active) {
            return '<li class="breadcrumb-item active">' . $text . '</li>';
        } else {
            return '<li class="breadcrumb-item">' . $a($href, $text) . '</li>';
        }
    };
    $catLinks = function ($term_ids, $taxonomy = 'category') use ($li) {
        $term_id = false;
        foreach ($term_ids  as $term_id) {
            $parent = get_term($term_id, $taxonomy);

            echo $li(esc_url(get_term_link($parent->term_id, $taxonomy)), $parent->name);
        }
    };

    if (!is_front_page() || is_paged()) {
        global $post;

        echo '<nav aria-label="breadcrumb"><ol class="breadcrumb">';

        echo $li($homeLink, $home);

        if (is_home()) {
            echo $li('', get_the_title(get_option('page_for_posts')), true);
        } else if (is_category()) {
            global $wp_query;
            $cat_obj   = $wp_query->get_queried_object();
            $thisCat   = get_category($cat_obj->term_id);

            if (get_post_type() == 'post') {
                echo $li(get_the_permalink(get_option('page_for_posts')), get_the_title(get_option('page_for_posts')));
            }

            if ($thisCat->parent != 0) {
                $parents = get_term_parents($thisCat->term_id);
                $catLinks($parents);
            }
            echo $li('', __('Category') . ': ' . single_cat_title('', false), true);
        } elseif (is_day()) {
            echo $li(get_year_link(get_the_time('Y')), get_the_time('Y'));
            echo $li(get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F'));

            echo $li('', get_the_time('d'), true);
        } elseif (is_month()) {
            echo $li(get_year_link(get_the_time('Y')), get_the_time('Y'));

            echo $li('', get_the_time('F'), true);
        } elseif (is_year()) {
            echo $li('', get_the_time('Y'), true);
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());

                echo $li($homeLink . '/' . $post_type->rewrite['slug'] . '/', $post_type->labels->singular_name);
            } else {
                $thisCat = get_the_category()[0];
                $parents = get_term_parents($thisCat->term_id);
                if ($parents) {
                    $catLinks($parents);
                } else {
                    echo $li(get_the_permalink(get_option('page_for_posts')), get_the_title(get_option('page_for_posts')));
                }
            }
            echo $li('', get_the_title(), true);
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());

            echo $li('', $post_type->labels->singular_name, true);
        } elseif (is_attachment()) {
            $parent = get_post($post->post_parent);
            $thisCat    = get_the_category($parent->ID)[0];
            $parents = get_term_parents($thisCat->term_id);
            $catLinks($parents);

            echo $li(get_permalink($parent), $parent->post_title);

            echo $li('', get_the_title(), true);
        } elseif (is_page() && !$post->post_parent) {
            echo $li('', get_the_title(), true);
        } elseif (is_page() && $post->post_parent) {
            $parent_id   = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page          = get_page($parent_id);
                $breadcrumbs[] = $li(get_permalink($page->ID), get_the_title($page->ID));
                $parent_id     = $page->post_parent;
            }

            echo implode('', array_reverse($breadcrumbs));

            echo $li('', get_the_title(), true);
        } elseif (is_search()) {
            echo $li('', __('Search results for') . ' "' . get_search_query() . '"', true);
        } elseif (is_tag()) {
            echo $li('', __('Posts tagged') . ' "' . single_tag_title('', false) . '"', true);
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);

            echo $li('', __('By Author: ') . ' ' . $userdata->display_name, true);
        } elseif (is_404()) {
            echo $li('', __('Error 404'), true);
        }

        echo '</ol></nav>';
    }
}

function tcf_related_posts()
{
    echo '<ul id="related-posts">';
    global $post;
    $tags = wp_get_post_tags($post->ID);
    if ($tags) {
        $tag_str = '';
        foreach ($tags as $tag) {
            $tag_str .= $tag->slug . ',';
        }
        $args = array(
            'tag' => $tag_str,
            'numberposts' => 5, /* you can change this to show more */
            'post__not_in' => array($post->ID)
        );
        $related_posts = get_posts($args);
        if ($related_posts) {
            foreach ($related_posts as $post) : setup_postdata($post); ?>
                <li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
            <?php endforeach;
        } else { ?>
            <?php echo '<li class="no_related_post">' . __('No Related Posts Yet!') . '</li>'; ?>
<?php }
    }
    wp_reset_postdata();
    echo '</ul>';
}

function excerpt_more($more, $post = null)
{
    if (!$post) {
        global $post;
    }
    // edit here if you like
    return '...  <a class="excerpt-read-more" href="' . get_permalink($post->ID) . '" title="' . __('Read ') . esc_attr(get_the_title($post->ID)) . '">' . __($more ?: 'Read more &raquo;') . '</a>';
}
