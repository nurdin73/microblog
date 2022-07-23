<?php

namespace App\Traits;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

trait Helper
{
    protected function dateDiffInDays(String $start_date, String $end_date): Int
    {
        $diff = strtotime($end_date) - strtotime($start_date);
        return abs(round($diff / 86400)) + 1;
    }

    protected function filterHistories($array, $filter)
    {
        $temp = [];
        foreach ($array as $key => $value) {
            if ($value['account_id'] == $filter) {
                array_push($temp, $value);
            }
        }
        return $temp;
    }

    protected function generateInt($length = 4)
    {
        $prefix = '1234567890';
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $prefix[rand(0, strlen($prefix) - 1)];
        }
        return $result;
    }

    public function deleteHtmlTag($string)
    {
        return preg_replace('/<[^>]*>/', '', $string);
    }

    public function getToken()
    {
        $key = 'nakedpress';
        $payload = [
            'name' => 'nakedpress-token',
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    public function decodeToken($token)
    {
        try {
            $key = 'nakedpress';
            return JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Exception $th) {
            return false;
        }
    }
}
