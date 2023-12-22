<?php

return [
    /**
     * Key used in cache
     * The default is ip_address, you can use either: ip_address or email or user_id
     */
    'key' => 'ip_address',

    /**
     * The cache to be used,
     * The default cache in config/cache.php is used if empty.
     */
    'cache' => 'file',

    /**
     * Specify guard to be used if you are using email or user_id
     * The default guard in config/auth.php is used if empty
     */
    'user_guard' => '',

    /**
     * Enable email notification for when a user is banned
     */
    'enable_email_notification' => false,

    /**
     * Email address to be used for email notification
     */
    'email_address' => '',
];
