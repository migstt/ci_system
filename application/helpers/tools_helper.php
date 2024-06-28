<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('cute_print')) {
    function cute_print($data, $fix = false)
    {
        echo '<div style="background: #ffffd8; border: 1px solid #c6c6a3; padding: 10px; margin-bottom:15px;z-index: 9999; ' . ($fix == true ? "position:fixed; top:0; left:0; right:0;" : "position:relative;") . ';">';
        echo '<pre style="background: #dfdfdf; margin: 0; padding: 0 5px;">';
        print_r($data);
        echo '</pre>';
        echo '</div>';
    }
}
