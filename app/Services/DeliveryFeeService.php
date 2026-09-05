<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeliveryFeeService
{
    const BASE_FEE = 100;

    /**
     * Road distance in km between two points, following actual streets (OSRM).
     * Falls back to haversine * 1.3 (rough road-distance approximation) if OSRM is unreachable.
     *
     * @return array{distance_km: float, duration_min: ?float, geometry: ?array, source: string}
     */
    public function getRouteDistance(float $lat1, float $lng1, float $lat2, float $lng2): array
    {
        try {
            $response = Http::timeout(5)->get(
                "https://router.project-osrm.org/route/v1/driving/{$lng1},{$lat1};{$lng2},{$lat2}",
                [
                    'overview'   => 'full',
                    'geometries' => 'geojson',
                ]
            );

            if ($response->ok()) {
                $data = $response->json();
                if (($data['code'] ?? null) === 'Ok' && !empty($data['routes'][0])) {
                    $route = $data['routes'][0];
                    return [
                        'distance_km'  => round($route['distance'] / 1000, 2),
                        'duration_min' => round($route['duration'] / 60, 1),
                        // GeoJSON gives [lng, lat] pairs — caller must flip for Leaflet
                        'geometry'     => $route['geometry']['coordinates'] ?? null,
                        'source'       => 'osrm',
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::warning('OSRM routing failed: ' . $e->getMessage());
        }

        $straightKm = $this->haversineKm($lat1, $lng1, $lat2, $lng2);
        return [
            'distance_km'  => round($straightKm * 1.3, 2),
            'duration_min' => null,
            'geometry'     => null,
            'source'       => 'haversine_fallback',
        ];
    }

    public function haversineKm(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $R    = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a    = sin($dLat / 2) ** 2
              + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    /**
     * ₱100 base + ₱18/km (first 5km) + ₱15/km (6–20km) + ₱12/km (21km+)
     */
    public function calculateFee(float $km): float
    {
        if ($km <= 0) {
            return self::BASE_FEE;
        }

        $fee  = self::BASE_FEE;
        $fee += min($km, 5) * 18;

        if ($km > 5) {
            $fee += (min($km, 20) - 5) * 15;
        }

        if ($km > 20) {
            $fee += ($km - 20) * 12;
        }

        return round($fee, 2);
    }

    /**
     * Convenience: distance + fee in one call.
     */
    public function quote(float $bakerLat, float $bakerLng, float $custLat, float $custLng): array
    {
        $route = $this->getRouteDistance($bakerLat, $bakerLng, $custLat, $custLng);
        $route['delivery_fee'] = $this->calculateFee($route['distance_km']);
        return $route;
    }
}