<?php

if (php_sapi_name() !== 'cli') {
    die("Meant to be run from command line");
}

global $wpdb;

echo implode(' ', $wpdb->tables()) . "\n";

WP_CLI::success("The script has run!");
