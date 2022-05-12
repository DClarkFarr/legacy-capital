<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Flush rewrite rules for custom post types
// add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules

use App\Utils\Schema;

function bones_flush_rewrite_rules()
{
    flush_rewrite_rules();
}


/** 
 * Add Post Types / Field Groups
 */
add_action('init', 'cpt_add_reviews');
add_action('init', 'cpt_add_employees');
add_action('init', 'cpt_add_services');

/**
 *  Init texamples 
 */
// add_action('init', 'example_post_types');
// add_action('init', 'example_field_groups');


function cpt_add_reviews()
{
    Schema::addPostType([
        'name_singular' => 'Review',
        'name_plural' => 'Reviews',
        'exclude_from_search' => true,
        'has_archive' => false,
        'supports' => ['title'],
        'publicly_queryable' => false,
    ]);
    Schema::addFieldGroup([
        'title' => 'Reviews',
        'location' => [
            'post_type' => ['review'],
        ],
        'fields' => [
            [
                'label' => 'Description',
                'type' => 'textarea',
            ],
            [
                'label' => 'Rating',
                'type' => 'number',
                'min' => 1,
                'max' => 5,
            ],
            [
                'label' => 'Author Name',
            ],
            [
                'label' => 'Author Image',
                'type' => 'image',
                'return_format' => 'id',
            ],
            [
                'label' => 'Date Published',
                'type' => 'date_picker',
                'display_format' => 'd/m/Y',
                'return_format' => 'd/m/Y',
            ],
        ]
    ]);
}

function cpt_add_employees()
{
    Schema::addPostType([
        'name_singular' => 'Employee',
        'name_plural' => 'Employees',
        'exclude_from_search' => true,
        'has_archive' => false,
        'supports' => ['title', 'thumbnail'],
        'publicly_queryable' => false,
    ]);

    Schema::addFieldGroup([
        'title' => 'Employee Information',
        'location' => [
            'post_type' => ['employee'],
        ],
        'fields' => [
            [
                'label' => 'email',
                'type' => 'email',
            ],
            [
                'label' => 'phone',
                'type' => 'text',
            ],
            [
                'label' => 'Position/Job Title',
                'key' => 'position',
                'type' => 'text',
            ],
        ],
    ]);
}

function cpt_add_services()
{
    Schema::addPostType([
        'name_singular' => 'Service',
        'name_plural' => 'Services',
        'exclude_from_search' => true,
        'has_archive' => false,
        'supports' => ['title', 'editor', 'thumbnail'],
        'publicly_queryable' => true,
    ]);
}

/** Example Post types / Field Groups */

// let's create the function for the custom type
function example_post_types()
{
    // creating (registering) the custom type 

    Schema::addPostType([
        'name_singular' => 'Example Post Type',
        'name_plural' => 'Example Post Types',
    ]);

    Schema::addTaxonomy([
        'name_singular' => 'Example Category',
        'name_plural' => 'Example Categories',
        'post_types' => ['example_post_type'],
    ]);

    Schema::addTaxonomy([
        'name_singular' => 'Example Tag',
        'name_plural' => 'Example Tags',
        'post_types' => ['example_post_type'],
        'hierarchical' => false,
    ]);

    /* this adds your post categories to your custom post type */
    // register_taxonomy_for_object_type( 'category', 'custom_type' );
    /* this adds your post tags to your custom post type */
    // register_taxonomy_for_object_type( 'post_tag', 'custom_type' );

}

function example_field_groups()
{

    Schema::addFieldGroup([
        'title' => 'Custom Type',
        'location' => [
            'post_type' => ['example_post_type'],
        ],
        'fields' => [
            array(
                'label' => 'Item 1',
                'type' => 'textarea',
            ),
        ],
    ]);

    Schema::addFieldGroup([
        'title' => 'Test Fields',
        'location' => array(
            array(
                'post_type' => ['example_post_type'],
            ),
        ),
        'fields' => [
            [
                'label' => 'Image Array',
                'type' => 'image',
                'return_format' => 'array',
            ],
            [
                'label' => 'Image URL',
                'type' => 'image',
                'return_format' => 'url',
            ],
            [
                'label' => 'Image ID',
                'type' => 'image',
                'return_format' => 'id',
            ]
        ],
    ]);
}
