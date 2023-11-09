<?php


namespace App\Models;

class Weather{
    private string $temperature;
    private string $windSpeed;

    public function __construct(string $temperature, string $windSpeed)
    {
        $this->temperature=$temperature;
        $this->windSpeed =$windSpeed;
    }

    public function getTemperature(): string
    {
        return $this->temperature;
    }

    public function getWindSpeed(): string
    {
        return $this->windSpeed;
    }
}