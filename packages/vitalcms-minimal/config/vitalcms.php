<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Table Prefix
    |--------------------------------------------------------------------------
    |
    | Prefix for all VitalCMS tables to avoid conflicts.
    |
    */
    'table_prefix' => env('VITALCMS_TABLE_PREFIX', 'cms_'),

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Configure caching for better performance.
    |
    */
    'cache' => [
        'enabled' => env('VITALCMS_CACHE_ENABLED', true),
        'ttl' => env('VITALCMS_CACHE_TTL', 3600), // 1 hour
        'prefix' => 'vitalcms:',
    ],

    /*
    |--------------------------------------------------------------------------
    | Filament Configuration
    |--------------------------------------------------------------------------
    |
    | Configure Filament integration.
    |
    */
    'filament' => [
        'enabled' => true,
        'navigation_group' => 'VitalCMS',
        'navigation_sort' => 200,
        'resources' => [
            'enabled' => true,
            'auto_register' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Hero Sections Configuration
    |--------------------------------------------------------------------------
    |
    | Configure hero sections behavior.
    |
    */
    'hero_sections' => [
        'cache_key' => 'vitalcms:hero_sections',
        'default_height' => 500,
        'allowed_types' => ['image', 'video', 'gradient'],
        'image_upload_path' => 'hero-sections',
    ],

    /*
    |--------------------------------------------------------------------------
    | Services Configuration
    |--------------------------------------------------------------------------
    |
    | Configure services management.
    |
    */
    'services' => [
        'cache_key' => 'vitalcms:services',
        'default_image_path' => 'services',
        'categories_enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Contact Form Configuration
    |--------------------------------------------------------------------------
    |
    | Configure contact form behavior.
    |
    */
    'contact' => [
        'enabled' => true,
        'email_notifications' => env('VITALCMS_CONTACT_EMAIL_NOTIFICATIONS', true),
        'notification_email' => env('VITALCMS_NOTIFICATION_EMAIL', 'admin@example.com'),
        'auto_reply' => env('VITALCMS_CONTACT_AUTO_REPLY', true),
        'spam_protection' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | Configure API behavior for frontend integration.
    |
    */
    'api' => [
        'enabled' => true,
        'rate_limit' => '60,1', // 60 requests per minute
        'cors_enabled' => true,
        'cors_origins' => [
            'http://localhost:3000', // Next.js dev
            'http://localhost:3001', // Next.js dev alt
        ],
    ],

];