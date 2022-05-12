<?php

namespace Sitedata;

function get_menus()
{
    $menus = get_theme_mod('nav_menu_locations');

    $menus_arr = [];
    foreach ($menus as $menu_slug => $term_id) {
        $menus_arr[] = get_menu($term_id);
    }
    return $menus_arr;
}
function get_menu($by_item, $returnArray = true)
{
    if (!is_numeric($by_item)) {
        $menus = get_theme_mod('nav_menu_locations');

        if (empty($menus[$by_item])) {
            throw new \Exception("Menu not found: " . $by_item);
        }
        $term_id = $menus[$by_item];
    } else {
        $term_id = $by_item;
    }

    $itemsNested = [];
    $itemsMapped = [];
    $menu = wp_get_nav_menu_object($term_id);
    $items = wp_get_nav_menu_items($term_id);

    _wp_menu_item_classes_by_context($items);

    foreach ($items as $item) {
        $itemsMapped[$item->ID] = $item;
    }

    foreach ($items as $item) {
        if (empty($item->children)) {
            $item->children = [];
        }
        if ($item->menu_item_parent > 0) {
            $parent = $itemsMapped[$item->menu_item_parent];
            $parent->children[] = $item;
        } else {
            $itemsNested[] = $item;
        }
    }

    $menu->items = Schema::map_menu_items($itemsNested, 1, $returnArray);

    return $menu;
}

function get_field_groups($args = [])
{
    return array_map(function ($group) {
        $group['fields'] = Schema::get_mapped_fields($group['key']);

        return $group;
    }, Schema::get_mapped_groups($args));
}

function post_type_data($post_type_slug)
{
    $groups = get_field_groups(array('post_type' => $post_type_slug));
    $allFields = [];
    foreach ($groups as $group) {
        $allFields = array_merge($allFields, $group['fields']);
    }
    return $allFields;
}
function post_types_data()
{
    $post_types = acf_get_post_types();
    $data = [];
    foreach ($post_types as $slug) {
        $data[$slug] = post_type_data($slug);
    }
    return $data;
}
function get_options($returnFields = false)
{
    $values = [];
    $fields = [];
    foreach (get_field_objects('options') ?: [] as $field) {
        $fields[$field['name']] = Schema::mapField($field);
        $values[$field['name']] = $field['value'];
    }

    if ($returnFields) {
        return $fields;
    }
    return $values;
}
function get_option_pages($withPages = false, $withValues = false)
{
    $pages = Schema::get_mapped_option_pages();

    if ($withValues) {
        $options = get_options();
    }

    foreach ($pages as $key => $page) {
        $groups = get_field_groups(['options_page' => $page['menu_slug']]);

        foreach ($groups as $group) {
            $fields = array_merge($pages[$key]['fields'], $group['fields']);
            if ($withValues) {
                foreach ($fields as $fkey => $field) {
                    $fields[$fkey]['value'] = !empty($options[$field['name']]) ? $options[$field['name']] : '';
                }
            }

            $pages[$key]['fields'] = $fields;
        }
    }

    if (!$withPages) {
        return $pages;
    }
    $fields = [];
    foreach ($pages as $page) {
        $fields = array_merge($fields, $page['fields']);
    }
    return $fields;
}

function create_page($post)
{
    $post = array_merge([
        'post_title'    => '',
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type'     => 'page',
        //'post_parent' => 111,
    ], $post);

    return wp_insert_post($post);
}


function tcf_disable_search()
{
    add_action('parse_query', function ($query, $error = true) {
        if (is_search()) {
            $query->is_search = false;
            $query->query_vars['s'] = false;
            $query->query['s'] = false;
            if ($error == true) {
                $query->is_404 = true;
            }
        }
    });

    add_filter('get_search_form', function ($a) {
        return null;
    });
    add_action('widgets_init', function () {
        unregister_widget('WP_Widget_Search');
    });
}

function the_schema_table()
{
    $data = site_data(true);
    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";
    echo "<h2>Site Info</h2>";
    echo "<code>get_bloginfo('key')</code>";
    echo "<table class='table table-sm'>";
    foreach ($data['info'] as $key => $val) {
        echo "<tr>";
        echo "<th>{$key}</th>";
        echo "<td>{$val}</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<br><br>";
    echo "<h2>Options Pages</h2>";
    echo "<code>the_field(key, 'option)</code>";
    echo "<table class='table table-sm'>";
    foreach ($data['options'] as $option) {
        echo "<tr>";
        echo "<td colspan='4'>";
        echo "<h4 class='my-2'>{$option['page_title']} <small>{$option['menu_slug']}</small></h4>";
        echo "</td>";
        echo "</tr>";
        foreach ($option['fields'] as $field) {
            echo "<tr>";
            echo "<td style='width:25px;'></td>";
            echo "<th>{$field['name']}</th>";
            echo "<td>{$field['label']}</td>";
            echo "<td>{$field['value']}</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    echo "<br><br>";

    echo "<h2>Post Types</h2>";
    echo "<code>the_field(key)</code>";
    echo "<table class='table table-sm'>";
    foreach ($data['post_types'] as $post_type => $fields) {
        echo "<tr>";
        echo "<td colspan='3'>";
        echo "<h4 class='my-2'>{$post_type}</h4>";
        echo "</td>";
        echo "</tr>";
        if (!empty($fields)) {
            foreach ($fields as $field) {
                echo "<tr>";
                echo "<td style='width:25px;'></td>";
                echo "<th>{$field['name']}</th>";
                echo "<td>{$field['label']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr>";
            echo "<td style='width:25px;'></td>";
            echo "<td colspan='2'>";
            echo "No Custom Fields";
            echo "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    echo "<br><br>";
}

function site_data($forReadout = false)
{
    $withPages = $withValues = true;
    if ($forReadout) {
        $withPages = $withValues = false;
    }
    return [
        'info' => blog_info_array(),
        'options' => get_option_pages($withPages, $withValues),
        'post_types' => post_types_data(),
        'menus' => get_menus(),
    ];
}

function blog_info_array()
{
    $columns = [
        'name',
        'description',
        'wpurl',
        'url',
        'admin_email',
        'version',
        'html_type',
        'language',
        'stylesheet_directory',
        'template_url',
    ];
    $arr = [];
    foreach ($columns as $c) {
        $arr[$c] = get_bloginfo($c);
    }
    return $arr;
}
