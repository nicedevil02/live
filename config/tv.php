<?php

return [
    'latest_version_code' => (int) env('TV_LATEST_VERSION_CODE', 1),
    'min_version_code'    => (int) env('TV_MIN_VERSION_CODE', 1),
    'apk_url'             => env('TV_APK_URL', 'https://talalive.ir/downloads/talalive-tv.apk'),
    'base_urls'           => [
        'https://talalive.ir',
        'https://www.talalive.ir',
    ],
    'heartbeat_interval_seconds' => (int) env('TV_HEARTBEAT_INTERVAL', 30),
];
