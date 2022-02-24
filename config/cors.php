<?php
// @see https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
return [
    'paths'                    => ['*'],
    'allowed_methods'          => ['GET', 'POST', 'OPTIONS'],
    'allowed_origins'          => [
        env('CORS_ALLOWED_ORIGIN', null),
    ],
    'allowed_origins_patterns' => [],
    'allowed_headers'          => ['*'],
    'exposed_headers'          => [],
    'max_age'                  => 0,
    'supports_credentials'     => false,
];
