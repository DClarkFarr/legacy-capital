<?php

if (php_sapi_name() !== 'cli') {
    die("Meant to be run from command line");
}

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../tcf/Functions/autoload.php');

echo "starting initial setup<br>";

$options = wp_load_alloptions();

if ($options['template'] != 'TCF Sage 10 Theme') {
    echo "Switching to TCF Sage 10 Theme\n";
    switch_theme('tcf-theme-10');
}

if (get_option('tcf_setup_complete') && empty($_GET['force'])) {
    die('setup has already run');
}

$pages_to_create = [
    [
        'post_title' => 'Home',
        'post_name' => 'home',
    ],
    [
        'post_title' => 'About',
        'post_name' => 'about',
    ],
    [
        'post_title' => 'Blog',
        'post_name' => 'blog',
    ],
    [
        'post_title' => 'Contact',
        'post_name' => 'contact',
    ],
];

echo 'creating pages...' . "\n";
foreach ($pages_to_create as $key => $row) {
    $exists = get_page_by_path($row['post_name']);
    echo 'checking page ' . $row['post_name'] . ': ';
    if (!$exists) {
        echo 'creating ' . "\n";
        $page_id = SiteData\create_page($row);
        $pages_to_create[$key] = get_page($page_id);
    } else {
        $pages_to_create[$key] = $exists;
        echo 'exists ' . "\n";
    }
}

//reading options
echo 'setting page options' . "\n";
update_option('blogdescription', '');

update_option('show_on_front', 'page');
update_option('page_on_front', $pages_to_create[0]->ID);
update_option('page_for_posts', $pages_to_create[2]->ID);

$locations = get_theme_mod('nav_menu_locations');

echo "creating menus\n";
foreach ([
    [
        'name' => 'Main Menu',
        'location' => 'primary_navigation',
    ],
    [
        'name' => 'Footer Menu',
        'location' => 'footer_navigation',
    ]
] as $menu) {
    $menu_name = $menu['name'];
    $location = $menu['location'];
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if ($menu_exists) {
        echo "menu " . $menu_name . " exists - skipping \n";
        continue;
    }
    $menu_id = wp_create_nav_menu($menu_name);

    foreach ($pages_to_create as $page) {
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => $page->post_title,
            'menu-item-object' => 'page',
            'menu-item-object-id' => get_page_by_path($page->post_name)->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish'
        ));
    }

    $locations[$location] = $menu_id;
}

set_theme_mod('nav_menu_locations', $locations);

update_option('tcf_setup_complete', 1, false);
