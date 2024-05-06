<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LocationController extends Controller
{
    const ROUND_DECIMALS        = 2;
    const MAX_CLOSEST_SECRETS   = 3;

    const DEFAULT_CACHE_TIME    = 1;

    public static array $conversionRates = [
        'km' => 1.853159616,
        'mile' => 1.1515
    ];

    public function findClosestSecrets(Request $request): JsonResponse
    {
        $originPoint = $request->only(['latitude', 'longitude']);
        $secrets = $this->getClosestSecrets($originPoint);
        return response()->json($secrets);
    }

    public function getDistance($pointA, $pointB, $unit = 'km'): float
    {
        return $this->getHaversineDistance($pointA, $pointB, $unit);
    }

    public function getClosestSecrets($originPoint): array
    {
        $client  = new Client(['verify' => false]);
        $remoteCall = $client->get('http://microservice_secret_nginx/api/v1/secrets');
        $data = json_decode($remoteCall->getBody(), true);
        $secrets = $data['data'];

        $cacheKey = 'L' . $originPoint['latitude'] . $originPoint['longitude'];
        $closestSecrets = Cache::remember(
            $cacheKey,
            self::DEFAULT_CACHE_TIME,
            function () use ($originPoint, $secrets) {
                $calculatedClosestSecrets = [];
                $distances = array_map(
                    function ($item) use ($originPoint) {
                        return $this->getDistance($item['location'], $originPoint);
                    },
                    $secrets
                );
                asort($distances);
                $distances = array_slice(
                    $distances,
                    0,
                    self::MAX_CLOSEST_SECRETS,
                    true
                );
                foreach ($distances as $key => $distance) {
                    $calculatedClosestSecrets[] = $secrets[$key];
                }
                return $calculatedClosestSecrets;
            }
        );
        return $closestSecrets;
    }

    public function getHaversineDistance($pointA, $pointB, $unit = 'km'): float
    {
        $distance = rad2deg(
            acos(
                (sin(deg2rad($pointA['latitude'])) *
                    sin(deg2rad($pointB['latitude']))) +
                    (cos(deg2rad($pointA['latitude'])) *
                        cos(deg2rad($pointB['latitude'])) *
                        cos(deg2rad($pointA['longitude'] -
                            $pointB['longitude'])))
            )
        ) * 60;
        return $this->convertDistance($distance, $unit);
    }

    public function getEuclideanDistance($pointA, $pointB, $unit = 'km'): float
    {
        $distance = sqrt(
            pow(abs($pointA['latitude'] - $pointB['latitude']), 2) +
                pow(abs($pointA['longitude'] - $pointB['longitude']), 2)
        );
        return $this->convertDistance($distance, $unit);
    }

    protected function convertDistance($distance, $unit = 'km'): float
    {
        $distance *= match (strtolower($unit)) {
            'mile'  => self::$conversionRates['mile'],
            default => self::$conversionRates['km'],
        };

        return round($distance, self::ROUND_DECIMALS);
    }
}
