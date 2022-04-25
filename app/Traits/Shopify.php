<?php
namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait Shopify
{
  public function getWithGraphQl(String $query)
  {
    $apiKey = config('shopify.api_key');
    $accessToken = config('shopify.access_token');
    $storeName = config('shopify.store_name');
    $version = config('shopify.version');
    $url = "https://{$storeName}.myshopify.com/api/$version/graphql.json";
    $headers = [
      "Content-Type: application/graphql",
      "X-Shopify-Storefront-Access-Token: $accessToken"
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $err = curl_error($ch);
    if ($err) {
      return $err;
    }
    $response = json_decode($response, true);
    return $response;
  }

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
    $typeApi = config('shopify.type_api');
    if($typeApi == 'admin_api') {
      $url = 'customers.json';
      try {
        return $this->req($url)->customers;
      } catch (\Exception $e) {
        return false;
      }
    }
  }

  /**
   * Get customer by id or access token
   * @param  String $id
   * @return Object
   */

  public function getCustomer($id)
  {
    $typeApi = config('shopify.type_api');
    if($typeApi == 'admin_api') {
      $url = "customers/$id.json";
      try {
        return $this->req($url)->customer->id;
      } catch (\Exception $e) {
        return false;
      }
    } else {
      $query = "
        query {
          customer(customerAccessToken: \"$id\") {
            id
          }
        }
      ";
      $response = $this->getWithGraphQl($query);
      if(isset($response['errors'])) {
        return false;
      } else {
        if($response['data']['customer'] != null) {
          $customerId = explode('/', $response['data']['customer']['id']);
          return $customerId[count($customerId) - 1];
        } else {
          return false;
        }
      }
    }
  }

  public function getAllCollections($searchQuery = '', $limit = 10)
  {
    $typeApi = config('shopify.type_api');
    if($typeApi == 'admin_api') {
      $url = "custom_collections.json";
      try {
        return $this->req($url)->custom_collections;
      } catch (\Exception $e) {
        Log::error($e->getMessage());
        return false;
      }
    } else {
      $query = "
        query {
          collections(first:$limit, query:\"{$searchQuery}\") {
            nodes {
              id,
              title,
            }
            pageInfo {
              hasNextPage,
              hasPreviousPage,
              startCursor,
              endCursor,
            },
          }
        }";
      $response = $this->getWithGraphQl($query);
      if(isset($response['errors'])) {
        return false;
      } else {
        if($response['data']['collections']['nodes'] != null) {
          return $response['data']['collections']['nodes'];
        } else {
          return false;
        }
      }
    }
  }

  public function getCollection($id)
  {
    $typeApi = config('shopify.type_api');
    if($typeApi == 'admin_api') {
      $url = "custom_collections/$id.json";
      try {
        return $this->req($url)->custom_collection;
      } catch (\Exception $e) {
        return false;
      }
    } else {
      $query = "
        query {
          collection(id: \"{$id}\") {
            id,
            title,
          }
        }";
      $response = $this->getWithGraphQl($query);
      return $response;
    }
  }
}