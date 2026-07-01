<?php

declare(strict_types=1);

return [
    'base_url' => env('SHORT_LINK_BASE_URL', env('APP_URL', 'http://localhost')),
    'short_code_length' => env('SHORT_CODE_LENGTH', 10),
    'length_of_original_url' => env('LENGTH_OF_ORIGINAL_URL', 50),
];
