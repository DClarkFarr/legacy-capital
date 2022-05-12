<?php

namespace TCF;

class Schema
{
    static function mapGroup($group)
    {
        return [
            'key' => $group['key'],
            'title' => $group['title'],
            'location' => $group['location'],
            'fields' => [],
        ];
    }
    static function mapField($field)
    {
        return [
            'key' => $field['key'],
            'label' => $field['label'],
            'name' => $field['name'],
            'type' => $field['type'],
            'value' => $field['value'],
        ];
    }
    static function mapOption($option)
    {
        return [
            'page_title' => $option['page_title'],
            'menu_slug' => $option['menu_slug'],
            'parent_slug' => $option['parent_slug'],
            'fields' => [],
        ];
    }

    static function get_mapped_fields($group_key)
    {
        return array_map(function ($field) {
            return static::mapField($field);
        }, acf_get_fields($group_key));
    }

    static function get_mapped_groups($args = [])
    {
        return array_map(function ($group) {
            return static::mapGroup($group);
        }, acf_get_field_groups($args));
    }

    static function get_mapped_option_pages()
    {
        $options = array_filter(acf_get_options_pages(), function ($option) {
            return !!$option['parent_slug'];
        });
        return array_map(function ($option) {
            return static::mapOption($option);
        }, $options);
    }

    static function map_menu_items($items, $depth = 1, $returnArray = true)
    {
        $arr = [];
        foreach ($items as $item) {
            if ($returnArray) {
                $arr[] = [
                    'ID' => $item->ID,
                    'post_title' => $item->post_title,
                    'post_status' => $item->post_status,
                    'post_name' => $item->post_name,
                    'guid' => $item->guid,
                    'menu_order' => $item->menu_order,
                    'menu_item_parent' => $item->menu_item_parent,
                    'type' => $item->type,
                    'title' => $item->title,
                    'url' => $item->url,
                    'depth' => $depth,
                    'children' => static::map_menu_items($item->children, $depth + 1, $returnArray),
                ];
            } else {
                $item->depth = $depth;
                $item->children = static::map_menu_items($item->children, $depth + 1, $returnArray);
                $arr[] = $item;
            }
        }

        return $arr;
    }

    static function textToSlug($text)
    {
        $text = preg_replace('@[^a-z0-9]@', ' ', strtolower($text));
        $text = trim(preg_replace('@ {2,}@', ' ', $text));

        return implode('_', explode(' ', $text));
    }

    static function addPostType($options)
    {
        $options = array_merge([
            'name_singular' => '',
            'name_plural'   => '',
        ], $options);

        $post_type = !empty($options['post_type']) ? $options['post_type'] : static::textToSlug($options['name_singular']);
        $slug = preg_replace('@_@', '-', $post_type);

        $label_defaults = [
            'name'          => $options['name_plural'],
            'singular_name' => $options['name_singular'],
            'all_items'     => 'All Custom ' . $options['name_plural'],
            'add_new'       => 'Add New',
            'add_new_item'  => 'Add New ' . $options['name_singular'],
            'edit'          => 'Edit',
            'edit_item'     => 'Edit ' . $options['name_singular'],
            'new_item'      => 'New ' . $options['name_singular'],
            'view_item'     => 'View ' . $options['name_singular'],
            'search_items'  => 'Search ' . $options['name_plural'],
            'not_found'     =>  'Nothing found in the Database.',
            'not_found_in_trash'    => 'Nothing found in Trash',
            'parent_item_colon'     => '',
        ];

        $post_type_defaults = array(
            'labels'            => [],
            'description'       => 'Custom Post Type: ' . $options['name_plural'] . ' / ' . $post_type,
            'public'            => true,
            'publicly_queryable'    => true,
            'exclude_from_search'   => false,
            'show_ui'           => true,
            'query_var'         => true,
            'menu_position'     => 8,
            'rewrite'            => array('slug' => $slug, 'with_front' => false, 'feed' => true),
            'has_archive'       => $slug,
            'capability_type'   => 'post',
            'hierarchical'      => false,
            'show_in_rest'      => true,
            'supports'          => array('title', 'editor', 'thumbnail', /* 'author', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky' */),
        );

        unset($options['name_singular'], $options['name_plural'], $options['post_type']);

        $postType = array_merge($post_type_defaults, $options);
        $postType['labels'] = array_merge($label_defaults, $postType['labels']);

        register_post_type($post_type, $postType);
    }

    static function addTaxonomy($options)
    {
        $options = array_merge([
            'name_plural' => '',
            'name_singular' => '',
        ], $options);

        $term_key = !empty($options['term_key']) ? $options['term_key'] : static::textToSlug($options['name_singular']);
        $term_slug = preg_replace('@_@', '-', $term_key);

        $post_types = !empty($options['post_types']) ? $options['post_types'] : [];
        if (!is_array($post_types)) {
            $post_types = [$post_types];
        }
        $label_defaults = [
            'name' => $options['name_plural'],
            'singular_name' => $options['name_singular'],
            'search_items' =>  'Search ' . $options['name_plural'],
            'all_items' => 'All ' . $options['name_plural'],
            'parent_item' => 'Parent ' . $options['name_singular'],
            'parent_item_colon' => 'Parent ' . $options['name_singular'] . ':',
            'edit_item' => 'Edit ' . $options['name_singular'],
            'update_item' => 'Update ' . $options['name_singular'],
            'add_new_item' => 'Add New ' . $options['name_singular'],
            'new_item_name' => 'New ' . $options['name_singular'],
        ];

        $term_defaults = [
            'labels' => [],
            'hierarchical' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_in_menu' => true,
            'show_ui' => true,
            'query_var' => true,
            'hide_meta_box' => false,
            'show_in_quick_edit' => true,
            'meta_box_cb' => true,
            'rewrite' => array('slug' => $term_slug),
        ];

        unset($options['name_singular'], $options['name_plural'], $options['term_key']);

        $term = array_merge($term_defaults, $options);
        $term['labels'] = array_merge($label_defaults, $term['labels']);

        if (empty($term['hierarchical'])) {
            unset($term['rewrite']);
        }

        register_taxonomy($term_slug, $post_types[0], $term);
        foreach ($post_types as $post_type) {
            register_taxonomy_for_object_type($term_slug, $post_type);
        }
    }

    static function addFieldGroup($group)
    {
        /** 
         * location param values
         */
        //Post
        //post_type, post_template, post_status, post_format, post_category, post_taxonomy, post
        //Page
        //page_template, page_type, page_parent, page
        //User
        //current_user, current_user_role, user_form, user_role
        //Forms
        //taxonomy, attachment, comment, widget, nav_menu, nav_menu_item, options_page

        /**
         * field_type values
         */
        //basic
        //text, textarea, number, range, email, url, password
        //content
        //image, file, wysiwyg, oembed, gallery
        //choice
        //select, checkbox, radio, button_group, true_false
        //relational
        //link, post_object, page_link, relationship, taxonomy, user
        //jquery
        //google_map, date_picker, date_time_picker, time_picker, color_picker
        /**
         * LAYOUT
         * message, accordion, tab, group, repeater, flexible_content, clone
         *  Repeater
         *      'min' => 1,
         *	    'max' => 5,
         *	    'layout' => 'table', 'block', 'row'
         *      'button_label' => 'custom label',
         *      'sub_fields' => [],
         * */

        $group['key'] = !empty($group['key']) ? $group['key'] : 'group_' . static::textToSlug($group['title']);

        $group['location'] = !empty($group['location']) ? $group['location'] : [];

        $group_defaults = array(
            'key' => '',
            'title' => '',
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => 1,
            'description' => 'Field Group: ' . $group['title'] . ' / ' . $group['key'],
            'fields' => [],
            'location' => [],
        );

        $group = array_merge($group_defaults, $group);

        $location = [];
        foreach ($group['location'] as $key => $orGroup) {
            if (is_numeric($key)) {
                $andGroups = [];
                foreach ($orGroup as $key1 => $andGroup) {
                    if (is_numeric($key1)) {
                        $andGroups[] = $andGroup;
                    } else {
                        foreach ($andGroup as $value) {
                            $andGroups[] = [
                                'param' => $key1,
                                'operator' => '==', // !=
                                'value' => $value,
                            ];
                        }
                    }
                }
                $location[] = $andGroups;
            } else {
                foreach ($orGroup as $value) {
                    $location[] = [
                        [
                            'param' => $key,
                            'operator' => '==', // !=
                            'value' => $value,
                        ]
                    ];
                }
            }
        }

        $group['location'] = $location;

        $group['fields'] = array_map(function ($field) use ($group) {
            return static::addField($field, $group['key']);
        }, $group['fields']);

        acf_add_local_field_group($group);
    }

    static function addField($field, $parent_key)
    {
        $field_defaults = array(
            'key' => '',
            'label' => '',
            'name' => '',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'maxlength' => '',
            'rows' => '',
            'new_lines' => '',
            'return_format' => 'array',
        );

        // 'conditional_logic' => array(
        //     array(
        //         array(
        //             'field' => 'field_5c550a04e5b9a',
        //             'operator' => '!=empty',
        //         ),
        //     ),
        // ),

        //operators
        //!=empty, ==empty, ==, !=, ==pattern, ==contains

        $field['key'] = !empty($field['key']) ? $field['key'] : 'field_' . $parent_key . '_' . static::textToSlug($field['label']);
        $field['name'] = !empty($field['name']) ? $field['name'] : static::textToSlug($field['label']);


        return static::configureFieldByType(array_merge($field_defaults, $field));
    }

    public static function configureFieldByType($field)
    {
        if ($field['type'] == 'repeater') {
            $defaults = [
                'sub_fields' => [],
                'min' => null,
                'max' => null,
                'layout' => 'table',
            ];

            $field = array_merge($defaults, $field);

            $field['sub_fields'] = array_map(function ($sub_field) use ($field) {
                return static::addField($sub_field, $field['key']);
            }, $field['sub_fields']);
        }
        return $field;
    }
}
