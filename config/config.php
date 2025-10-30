<?php
declare(strict_types=1);

return (object)[
    // Database (use real secrets in env or outside repo)
    'db' => (object)[
        'host' => '127.0.0.1',
        'port' => 3306,
        'name' => 'job_portal',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4'
    ],

    // App/site settings
    'site' => (object)[
        'base_url' => 'http://job-portal/public', // change to your production URL
        'uploads_path' => __DIR__ . '/../public/uploads',
        'uploads_url' => '/public/uploads',
        'max_resume_size' => 2 * 1024 * 1024, // 2 MB
        'allowed_resume_types' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']
    ],

    // Security
    'session' => (object)[
        'name' => 'jobportal_session'
    ]
];
