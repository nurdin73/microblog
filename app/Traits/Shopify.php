<?php
namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait Shopify
{

  public function req($url) {
    $apiKey = config('shopify.api_key');
    $accessToken = config('shopify.access_token');
    $storeName = config('shopify.store_name');
    $version = config('shopify.version');
    $url = "https://$apiKey:$accessToken@$storeName.myshopify.com/admin/api/$version/$url";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    $err = curl_error($ch);
    if ($err) {
      return $err;
    }
    return json_decode($output);
  }

  public function getAllCustomer()
  {
    $url = 'customers.json';
    try {
      return $this->req($url)->customers;
    } catch (\Exception $e) {
      return false;
    }
  }

  public function getCustomer($id)
  {
    $url = "customers/$id.json";
    try {
      return $this->req($url)->customer;
    } catch (\Exception $e) {
      return false;
    }
  }

  public function getAllCollections()
  {
    $url = "custom_collections.json";
    try {
      return $this->req($url)->custom_collections;
    } catch (\Exception $e) {
      return false;
    }
  }

  public function getCollection($id)
  {
    $url = "custom_collections/$id.json";
    try {
      return $this->req($url)->custom_collection;
    } catch (\Exception $e) {
      return false;
    }
  }
}