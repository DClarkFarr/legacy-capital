<?php

use TCF\Schema;

acf_add_options_page(array(
    'page_title'     => 'TCF Theme',
    'menu_title'     => 'TCF Theme',
    'menu_slug'     => 'tcf-theme',
    'capability'     => 'edit_posts',
    'position' => 30,
    'icon_url' => 'dashicons-admin-site',
));


acf_add_options_sub_page(array(
    'page_title'     => 'Business Information',
    'menu_title'    => 'Business Info',
    'parent_slug'    => 'tcf-theme',
));

acf_add_options_sub_page(array(
    'page_title'     => 'Website Social Media',
    'menu_title'    => 'Social Media',
    'parent_slug'    => 'tcf-theme',
));

acf_add_options_sub_page(array(
    'page_title'     => 'Footer Information',
    'menu_title'    => 'Footer Info',
    'parent_slug'    => 'tcf-theme',
));

acf_add_options_sub_page(array(
    'page_title'     => 'Page Selection',
    'menu_title'    => 'Page Select',
    'parent_slug'    => 'tcf-theme',
));

/*
acf_add_options_sub_page(array(
	'page_title' 	=> 'Home Page Slider',
	'menu_title'	=> 'Home Page Slider',
	'parent_slug'	=> 'tcf-theme',
));
*/

Schema::addFieldGroup([
    'title' => 'Form Select',
    'location' => [
        'options_page' => ['acf-options-page-select'],
    ],
    'fields' => [
        [
            'label' => 'Contact Form',
            'key' => 'form_contact',
        ],
        [
            'label' => 'Newsletter Form',
            'key' => 'form_newsletter',
        ]
    ]
]);
Schema::addFieldGroup([
    'title' => 'Page Select',
    'location' => [
        'options_page' => ['acf-options-page-select'],
    ],
    'fields' => [
        [
            'label' => 'Home Page',
            'key' => 'page_home',
            'type' => 'post_object',
            'post_type' => [
                'page'
            ]
        ],
        [
            'label' => 'About Us Page',
            'key' => 'page_about',
            'type' => 'post_object',
            'post_type' => [
                'page'
            ]
        ],
        [
            'label' => 'Contact Us Page',
            'key' => 'page_contact',
            'type' => 'post_object',
            'post_type' => [
                'page'
            ]
        ],
    ]
]);

Schema::addFieldGroup([
    'title' => 'Footer Info',
    'location' => [
        'options_page' => ['acf-options-footer-info'],
    ],
    'fields' => [
        [
            'label' => 'Column 1',
            'type' => 'textarea',
        ],
        [
            'label' => 'Column 2',
            'type' => 'textarea',
        ],
        [
            'label' => 'Column 3',
            'type' => 'textarea',
        ],
        [
            'label' => 'Column 4',
            'type' => 'textarea',
        ],
    ],
]);

Schema::addFieldGroup([
    'title' => 'Business Info',
    'location' => [
        'options_page' => ['acf-options-business-info'],
    ],
    'fields' => [
        [
            'label' => 'Logo',
            'type' => 'image',
            'return_format' => 'id',
        ],
        [
            'label' => 'Footer Logo',
            'type' => 'image',
            'return_format' => 'id',
        ],
        [
            'label' => 'Business Name',
        ],
        [
            'label' => 'Address 1',
        ],
        [
            'label' => 'Address 2',
        ],
        [
            'label' => 'City',
        ],
        [
            'label' => 'State',
        ],
        [
            'label' => 'Zip',
        ],
        [
            'label' => 'Phone',
        ],
        [
            'label' => 'Business Hours',
            'type' => 'textarea',
        ],
        [
            'label' => 'Contact Email',
        ],
        [
            'label' => 'Google Map Iframe',
            'type' => 'textarea',
        ],
    ],
]);

Schema::addFieldGroup([
    'title' => 'Site Aggregate Reviews',
    'location' => [
        'options_page' => ['acf-options-business-info'],
    ],
    'fields' => [
        [
            'label' => 'Rating Count',
        ],
        [
            'label' => 'Rating Value',
        ],
    ],
]);

Schema::addFieldGroup([
    'title' => 'Social Media Links',
    'location' => [
        'options_page' => ['acf-options-social-media'],
    ],
    'fields' => [
        [
            'label' => 'Facebook URL',
            'type' => 'url',
        ],
        [
            'label' => 'Twitter URL',
            'type' => 'url',
        ],
        [
            'label' => 'Google Plus URL',
            'type' => 'url',
        ],
        [
            'label' => 'Instagram URL',
            'type' => 'url',
        ],
        [
            'label' => 'Youtube URL',
            'type' => 'url',
        ],
        [
            'label' => 'Alignable URL',
            'type' => 'url',
        ],
    ],
]);

/*
acf_add_local_field_group(array (
	'key' => 'group_5599d1e9d2233',
	'title' => 'Slider',
	'fields' => array (
		array (
			'key' => 'field_5599d257f3558',
			'label' => 'Slides',
			'name' => 'slides',
			'type' => 'repeater',
			'instructions' => 'Each Slider',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'min' => '',
			'max' => '',
			'layout' => 'table',
			'button_label' => 'Add Row',
			'sub_fields' => array (
				array (
					'key' => 'field_5599d271f3559',
					'label' => 'Picture',
					'name' => 'picture',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array (
					'key' => 'field_5599d27cf355a',
					'label' => 'Headline',
					'name' => 'headline',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_5599d284f355b',
					'label' => 'Sub Headline',
					'name' => 'sub_headline',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-home-page-slider',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
));
*/