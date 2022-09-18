<?php

namespace App\Services;

use Illuminate\Support\Collection;
use SKAgarwal\GoogleApi\Exceptions\GooglePlacesApiException;
use SKAgarwal\GoogleApi\PlacesApi;

class GooglePlaceApi
{
    /**
     * @param $keyword
     * @return Collection|void
     */
    public function call($keyword)
    {
        $collection = collect();
        $googlePlace = new PlacesApi(config('services.google_api.api_key'));
        $recursive = false;
        try {
            $response1 = $googlePlace->textSearch($keyword, [
                'location' => geoip(\request()->ip())->lat . ',' . geoip(\request()->ip())->lon,
                'radius' => 5000,
                'region' => 'fr'
            ]);
            $collection->push($response1['results']);

            if($response1['next_page_token']) {
                while (!$recursive) {
                    sleep(2);
                    try {
                        $response2 = $googlePlace->textSearch($keyword, [
                            'location' => geoip(\request()->ip())->lat . ',' . geoip(\request()->ip())->lon,
                            'radius' => 5000,
                            'region' => 'fr',
                            'pagetoken' => $response1['next_page_token'] ?? null
                        ]);
                        $collection->push($response2['results']);
                        if($response2['next_page_token']) {
                            while (!$recursive) {
                                sleep(2);
                                try {
                                    $response3 = $googlePlace->textSearch($keyword, [
                                        'location' => geoip(\request()->ip())->lat . ',' . geoip(\request()->ip())->lon,
                                        'radius' => 5000,
                                        'region' => 'fr',
                                        'pagetoken' => $response2['next_page_token'] ?? null
                                    ]);
                                    $collection->push($response3['results']);

                                    if(isset($response3['next_page_token'])) {
                                        try {
                                            $response4 = $this->calling($response3, $googlePlace, $keyword, $collection);
                                            if(isset($response4['next_page_token'])) {
                                                try {
                                                    $this->calling($response4->response, $googlePlace, $keyword, $collection);
                                                }catch (\Exception $exception) {
                                                    dd($exception);
                                                }
                                            }
                                        }catch (\Exception $exception) {
                                            dd($exception);
                                        }
                                    }

                                }catch (GooglePlacesApiException $e) {
                                    dd($e->getMessage());
                                }
                                $recursive = true;
                            }
                        }
                    }catch (GooglePlacesApiException $e) {
                        dd($e);
                    }
                    $recursive = true;
                }
            }
            return $collection;
        } catch (GooglePlacesApiException $e) {
            dd($e);
        }
    }

    private function calling($response, $googlePlace, $keyword, $collection)
    {
        $recursive = false;
        if($response['next_page_token']) {
            while (!$recursive) {
                sleep(2);
                try {
                    $response2 = $googlePlace->textSearch($keyword, [
                        'location' => geoip(\request()->ip())->lat . ',' . geoip(\request()->ip())->lon,
                        'radius' => 5000,
                        'region' => 'fr',
                        'pagetoken' => $response['next_page_token']
                    ]);
                    $collection->push($response2['results']);

                }catch (GooglePlacesApiException $e) {
                    dd($e);
                }
                $recursive = true;
            }
        }

        return (object) [
            'collection' => $collection,
            'response' => $response2
        ];
    }

    public function getAddress($lat, $lon, $type)
    {
        switch ($type) {
            case 'address':
                return $this->CallAddress($lat, $lon)->name;
            case 'postal':
                return $this->CallAddress($lat, $lon)->postcode;
            case 'city':
                return $this->CallAddress($lat, $lon)->city;
        }
    }

    public function CallAddress($lat, $lng): object|array
    {
        $response = \Http::get('https://api-adresse.data.gouv.fr/reverse/?lon=2.37&lat=48.357', [
            'lon' => $lng,
            'lat' => $lat
        ])->object();
        return $response->features[0]->properties;
    }

    public static function getCity($vicinity): string
    {
        $ex = explode(', ', $vicinity);
        $match = preg_match('/^[A-Za-z]+$/', $ex[1]);
        return $match ? : '';
    }

    public static function getPostal($city)
    {
        if($city != '') {
           $match = preg_match('/^[0-9]$/', $city);
           return $match;
        } else {
            return null;
        }
    }
}
