<?php

return [
    'latest_version'      => env('TV_LATEST_VERSION', '1.0.5'),
    'latest_version_code' => (int) env('TV_LATEST_VERSION_CODE', 7),
    'min_version_code'    => (int) env('TV_MIN_VERSION_CODE', 2),
    'apk_url'             => env('TV_APK_URL', 'https://talalive.ir/downloads/talalive-tv.apk'),
    'file_size'           => '46.3 MB',
    'base_urls'           => [
        'https://talalive.ir',
        'https://www.talalive.ir',
    ],
    'heartbeat_interval_seconds' => (int) env('TV_HEARTBEAT_INTERVAL', 30),
    'render_mode'                => env('TV_RENDER_MODE', 'web'), // web | native | auto
];

