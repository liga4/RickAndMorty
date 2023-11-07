<?php

namespace App;

use GuzzleHttp\Client;

class WeatherApi{
    private Client $client;
    public function __construct()
    {
        $this->client = new Client;
    }

    public function fetchData(string $city){
        $apiKey = "fb090b0c9cd59e04fc7f704871c01314";
        $fetchCityData = $this->client->get("http://api.openweathermap.org/geo/1.0/direct?q=$city&limit=1&appid=$apiKey");
        $dataOfCity = json_decode((string)$fetchCityData->getBody());
        $lat = $dataOfCity[0]["lat"];
        $lon = $dataOfCity[0]["lon"];

        $fetchWeatherData = $this->client->get("https://api.openweathermap.org/data/2.5/weather?units=metric&lat=$lat&lon=$lon&appid=$apiKey");
        $dataOfWeather = json_decode((string)$fetchWeatherData->getBody());

        return $dataOfWeather->main->temp;

    }
}