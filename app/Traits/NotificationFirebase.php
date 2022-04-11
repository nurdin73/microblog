<?php
namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

trait NotificationFirebase
{
    public function url()
    {
        return property_exists($this, 'url') ? $this->url : "https://fcm.googleapis.com/fcm/send";
    }

    public function method()
    {
        return property_exists($this, 'method') ? $this->method : "POST";
    }

    public function send($notifications)
    {
        $body = json_encode($notifications);
        $request = new Request($this->method(), $this->url(), $this->headers(), $body);
        $promise = $this->client()->sendAsync($request)->then(function($response) {
            Log::info("send notif firebase \n " . $response->getBody()->getContents());
        });
        $promise->wait();
        return "success";
    }

    public function subscribe(Array $tokens, String $topic)
    {
        if(count($tokens) > 0) {
            $this->url = "https://iid.googleapis.com/iid/v1:batchAdd";
            $body = json_encode([
                'to' => "/topics/$topic",
                'registration_tokens' => $tokens
            ]);
            $request = new Request($this->method(), $this->url(), $this->headers(), $body);
            $promise = $this->client()->sendAsync($request)->then(function($res) use($topic) {
                Log::info("Subscribe to topic $topic \n" . $res->getBody());
            });
            $promise->wait();
        }
    }

    public function unsubscribe(Array $tokens, String $topic)
    {
        if(count($tokens) > 0) {
            $this->url = "https://iid.googleapis.com/iid/v1:batchRemove";
            $body = json_encode([
                'to' => "/topics/$topic",
                'registration_tokens' => $tokens
            ]);
            $request = new Request($this->method(), $this->url(), $this->headers(), $body);
            $promise = $this->client()->sendAsync($request)->then(function($res) use($topic) {
                Log::info("Unsubscribe topic $topic \n" . $res->getBody());
            });
            $promise->wait();
        }
    }

    protected function client()
    {
        return new Client(['verify' => false]);
    }

    public function headers()
    {
        return [
            "Authorization" => "key=" . config('firebase.key'),
            "Content-Type" => "application/json"
        ];
    }
}