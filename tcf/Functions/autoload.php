<?php

$dir = scandir(__DIR__);

foreach ($dir as $base) {
    $file = __DIR__ . '/' . $base;
    if (is_file($file)) {
        require_once($file);
    }
}
