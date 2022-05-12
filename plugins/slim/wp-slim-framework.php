<?php

/**
 * Created by JetBrains PhpStorm.
 * Date: 7/30/13
 * Time: 10:20 AM
 * Plugin Name: Wordpress Slim framework
 * Description: Slim framework integration with Wordpress
 * Version: 1.0
 * Author: Constantin Botnari
 * License: GPLv2
 */

if (is_admin()) {
    require_once 'SlimWpOptions.php';
    new \Slim\SlimWpOptions();
}

add_filter('rewrite_rules_array', function ($rules) {
    $new_rules = array(
        '(' . get_option('slim_base_path', 'slim/api/') . ')' => 'index.php',
    );
    $rules = $new_rules + $rules;
    return $rules;
});

add_action('init', function () {
    if (strstr($_SERVER['REQUEST_URI'], get_option('slim_base_path', 'slim/api/'))) {
        require_once get_theme_file_path() . '/api.php';
        exit;
    }
});
