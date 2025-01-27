<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Cross-Origin Resource Sharing (CORS) Configuration
  |--------------------------------------------------------------------------
  |
  | This configuration determines what cross-origin operations are allowed
  | to execute in web browsers. You are free to adjust these settings
  | as needed for your application.
  |
  */

  'paths' => ['api/*'],
  'allowed_methods' => ['*'],
  'allowed_origins' => ['*'],
  'allowed_origins_patterns' => [],
  'allowed_headers' => ['*'],
  'exposed_headers' => [],
  'max_age' => 0,
  'supports_credentials' => false,
];
