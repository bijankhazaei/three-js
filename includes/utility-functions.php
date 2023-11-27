<?php

/**
 * return path of file
 *
 * @param $filename
 * @return string
 */
function wtj_get_path($filename = ''): string
{
    return ACF_PATH . ltrim($filename, '/');
}

/**
 * Include needed PHP files
 *
 * @param string $filename
 * @return void
 */
function wtj_include(string $filename = '')
{
    $file_path = wtj_get_path($filename);
    if (file_exists($file_path)) {
        include_once $file_path;
    }
}