<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GeocodeService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getCoordinates(string $cityName)
    {
        $url = 'https://nominatim.openstreetmap.org/search';

        $response = $this->httpClient->request('GET', $url, [
            'query' => [
                'q' => $cityName,
                'format' => 'json',
                'limit' => 1,
            ],
        ]);

        $data = $response->toArray();

        if (!empty($data)) {
            $latitude = $data[0]['lat'];
            $longitude = $data[0]['lon'];

            return [
                'latitude' => $latitude,
                'longitude' => $longitude,
            ];
        }

        return null; // Retourne null si aucune coordonnée n'est trouvée
    }
}
