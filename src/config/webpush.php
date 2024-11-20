<?php

return [
    'vapid' => [
        'subject' => env('VAPID_SUBJECT', 'mailto:hanzawa@aris-kk.co.jp'),
        'public_key' => env('VAPID_PUBLIC_KEY'),
        'private_key' => env('VAPID_PRIVATE_KEY'),
    ],
];


