<?php

return [

    /*
     * Badge HTML generated ID prefix
     * Default: rankchecker-badge
     */
    'prefix' => env('BADGE_PREFIX', 'rankchecker'),

    /*
     * Filesystems Disk where store Badges JS
     */
    'storage_js' => env('BADGE_STORAGE_DISK_JS', 'badges-js'),

    /*
     * Filesystems Disk where store Badges Images
     */
    'storage_img' => env('BADGE_STORAGE_DISK_IMG', 'badges-img'),

    'default_img_url' => env('BADGE_DEFAULT_IMG_URL', '#'),

    'link_url' => env('BADGE_LINK_URL', 'https://rankchecker.io'),

    'link_target' => env('BADGE_LINK_TARGET', '_blank'),

    'img_alt' => env('BADGE_IMG_ALT', 'RankChecker.io'),

];
