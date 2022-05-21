<?php

namespace Thumbnails;

use function Queries\get_post_id;

function the_post_thumbnail_title($post_id = null)
{
    return esc_html(get_post_thumbnail_title($post_id));
}
function get_post_thumbnail_title($post_id = null)
{
    return get_attachment_title(get_post_thumbnail_id(get_post_id($post_id)));
}
function the_post_thumbnail_alt($post_id = null)
{
    return esc_html(get_post_thumbnail_alt($post_id));
}
function get_post_thumbnail_alt($post_id = null)
{
    return get_attachment_alt(get_post_thumbnail_id(get_post_id($post_id)));
}

function get_attachment_title($attachment_id)
{
    return get_the_title($attachment_id);
}
function the_attachment_title($attachment_id)
{
    echo get_attachment_title($attachment_id);
}

function the_attachment_alt($attachment_id = null)
{
    return esc_html(get_attachment_alt($attachment_id));
}
function get_attachment_alt($attachment_id = null)
{
    return get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
}

function thumbnail($size = 'original', $attrs = [], $post_id = null)
{
    $attachment_id = get_post_thumbnail_id(get_post_id($post_id));
    return attachment($attachment_id, $size, $attrs);
}

function attachment($attachment_id, $size = 'original', $attrs = [])
{
    $attrs = array_merge([
        'lazy' => true,
        'class' => 'img-fluid',
        'style' => '',
        'title' => get_attachment_title($attachment_id),
        'alt' => get_attachment_alt($attachment_id),
    ], $attrs);

    if (is_array($size)) {
        $used = false;
        foreach ($size as $breakpoint => $s) {
            list($url, $width, $height, $custom) = wp_get_attachment_image_src($attachment_id, $s);
            if (!$custom && $used) {
                unset($size[$breakpoint]);
                continue;
            }
            $size[$breakpoint] = esc_url($url) . " {$width}w";
            $used = true;
        }
    } else {
        $size = wp_get_attachment_image_url($attachment_id, $size);
    }

    return img($size, $attrs);
}

function img($url, $attrs = [])
{
    $attrs = array_filter($attrs);

    $src = '';

    if (!empty($attrs['lazy'])) {
        $src .= 'data-';
        if (empty($attrs['class'])) {
            $attrs['class'] = '';
        }
        $attrs['class'] .= ' lozad';

        unset($attrs['lazy']);
    }

    if (is_array($url)) {
        $src .= 'srcset="' . implode(',', $url) . '"';

        foreach ($url as $breakpoint => $s) {
            $url[$breakpoint] = substr($s, 0, strpos($s, ' '));
        }
        $attrs['data-sizes'] = esc_attr(json_encode($url));
    } else {
        $src .= 'src="' . $url . '"';
    }

    $attributes = '';
    foreach ($attrs as $prop => $value) {
        $attributes .= " {$prop}='" . esc_html($value) . "'";
    }

    return "<img {$src} {$attributes}>";
}
