<?php

namespace App\Service;

use GuzzleHttp\Client;

class MapboxService
{
    protected $apiBaseUrl = 'https://api.mapbox.com/geocoding/v5/mapbox.places/';
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('MAPBOX_API_KEY');
    }

    public function forwardGeocode($query)
    {
        $client = new Client();

        $response = $client->request('GET', $this->apiBaseUrl . urlencode($query) . '.json', [
            'query' => [
                'access_token' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
