<?php
return [
  'api_key' => env('SHOPIFY_API_KEY'),
  'secret_key' => env('SHOPIFY_SECRET_KEY'),
  'access_token' => env('SHOPIFY_ACCESS_TOKEN'),
  'store_name' => env('SHOPIFY_STORE_NAME'),
  'version' => env('SHOPIFY_API_VERSION'),
  'type_api' => env('SHOPIFY_API_TYPE', 'storfront_api'),
];