<?php

namespace App\Api;

use Exception;
use Illuminate\Support\Facades\Http;

class NovaApi
{
    private $api_key;
    public const API_URL = 'https://nova.snapt.net/api/';

    public function __construct(string $api_key)
    {
        $this->api_key = $api_key;
        if (empty($api_key)) {
            throw new Exception('You must place your Nova API key in ~/.nova-api-key');
        }
    }

    public function get(string $url)
    {
        $result = Http::acceptJson()->withToken($this->api_key)->get(self::API_URL . $url);
        return $result->json();
    }

    public function post(string $url, $args)
    {
        $result = Http::acceptJson()->withToken($this->api_key)->post(self::API_URL . $url, $args);
        return $result->json();
    }
}
