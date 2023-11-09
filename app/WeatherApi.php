<?php

namespace App;

use App\Models\Weather;
use GuzzleHttp\Client;

class WeatherApi{
    private Client $client;
    public function __construct()
    {
        $this->client = new Client(['verify' => 'C:\Windows\cacert.pem']);
    }

    public function fetchData(string $city): Weather
    {
        $apiKey = "fb090b0c9cd59e04fc7f704871c01314";
        $fetchCityData = $this->client->get("http://api.openweathermap.org/geo/1.0/direct?q=$city&limit=1&appid=$apiKey");
        $dataOfCity = json_decode((string)$fetchCityData->getBody(), true);
        $lat = $dataOfCity[0]["lat"];
        $lon = $dataOfCity[0]["lon"];

        $fetchWeatherData = $this->client->get("https://api.openweathermap.org/data/2.5/weather?units=metric&lat=$lat&lon=$lon&appid=$apiKey");
        $dataOfWeather = json_decode((string)$fetchWeatherData->getBody());

        return new Weather($dataOfWeather->main->temp, $dataOfWeather->wind->speed);

    }
}