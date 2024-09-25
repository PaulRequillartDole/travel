<?php

namespace App\Service;

use App\GeoData;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GeocodeService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getGeoData(string $cityName)
    {
        $url = 'https://nominatim.openstreetmap.org/search';

        $cityName = explode(",", $cityName)[0];
        $response = $this->httpClient->request('GET', $url, [
            'query' => [
                'q' => $cityName,
                'format' => 'json',
                'limit' => 1,
            ],
        ]);

        $data = $response->toArray();

        if (!empty($data)) {
            return new GeoData(
                latitude: $data[0]['lat'],
                longitude: $data[0]['lon'],
                name: $data[0]['name'],
                displayName: $data[0]['display_name'],
                type: $data[0]['addresstype']
            );
        }

        return null; // Retourne null si aucune coordonnée n'est trouvée
    }
}
