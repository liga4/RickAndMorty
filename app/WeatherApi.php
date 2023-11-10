<?php

namespace App;

use App\Models\Weather;
use GuzzleHttp\Client;
use Dotenv\Dotenv;

class WeatherApi{
//    private Client $client;
//    public function __construct()
//    {
//        $this->client = new Client();
//    }

    public function fetchData(string $city): Weather
    {
        $dotenv = Dotenv::createImmutable('../');
        $dotenv->load();

        $fetchCityData = file_get_contents("http://api.openweathermap.org/geo/1.0/direct?q=$city&limit=1&appid={$_ENV["WEATHER_API_KEY"]}");
        $dataOfCity = json_decode($fetchCityData, true);
       // $fetchCityData = $this->client->get("http://api.openweathermap.org/geo/1.0/direct?q=$city&limit=1&appid=$apiKey");
//        $dataOfCity = json_decode((string)$fetchCityData->getBody(), true);
        $lat = $dataOfCity[0]["lat"];
        $lon = $dataOfCity[0]["lon"];

//        $fetchWeatherData = $this->client->get("https://api.openweathermap.org/data/2.5/weather?units=metric&lat=$lat&lon=$lon&appid=$apiKey");
//        $dataOfWeather = json_decode((string)$fetchWeatherData->getBody());
        $fetchWeatherData = file_get_contents("https://api.openweathermap.org/data/2.5/weather?units=metric&lat=$lat&lon=$lon&appid={$_ENV["WEATHER_API_KEY"]}");
        $dataOfWeather = json_decode($fetchWeatherData);

        return new Weather($dataOfWeather->main->temp, $dataOfWeather->wind->speed);

    }
}