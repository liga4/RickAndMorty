<?php

namespace App;

use App\Models\Episode;
use Carbon\Carbon;
use GuzzleHttp\Client;

class Api
{
    private Client $client;
    private const API_URL = 'https://rickandmortyapi.com/api/episode';

    public function __construct()
    {
        $this->client = new Client(['verify' => 'C:\Windows\cacert.pem']);
    }

    public function fetchEpisodes(): array
    {
        $episodes = [];
        $page = 1;
        while (true) {
            $response = $this->client->get(self::API_URL . "?page=$page");
            $data = json_decode((string)$response->getBody());

            foreach ($data->results as $result) {
                $episodes[] = new Episode(
                    $result->id,
                    $result->name,
                    Carbon::parse($result->air_date),
                    $result->episode,
                    $result->characters
                );
            }
            $page++;
            if ($data->info->next == null) {
                break;
            }
        }
        return $episodes;
    }

    public function fetchEpisode(int $id): Episode
    {
        $response = $this->client->get(self::API_URL . "/{$id}");
        $result = json_decode((string)$response->getBody());

        return new Episode(
            $result->id,
            $result->name,
            Carbon::parse($result->air_date),
            $result->episode,
            $result->characters
        );
    }

    public function fetchSeasons(): array
    {
        $episodes = $this->fetchEpisodes();
        $seasons = [];

        /** @var Episode $episode */
        foreach ($episodes as $episode) {
            $episodeSeason = (int)substr($episode->getEpisode(), 1, 2);
            $seasons[] = [
                'season_id' => $episodeSeason
            ];
        }
        ksort($seasons);
        return array_values(array_unique(array_column($seasons, 'season_id')));
    }

    public function fetchEpisodesBySeasonId(int $seasonId): array
    {
        $episodes = [];
        /** @var Episode $episode */
        foreach ($this->fetchEpisodes() as $episode) {
            $episodeSeason = (int)substr($episode->getEpisode(), 1, 2);

            if ($episodeSeason === $seasonId) {
                $episodes[] = [
                    'id' => $episode->getId(),
                    'name' => $episode->getName(),
                    'air_date' => $episode->getAirDate(),
                    'episode' => $episode->getEpisode()
                ];
            }
        }
        return $episodes;
    }

    public function fetchEpisodeForSearch(string $searchedEpisode):array{
        $eps = [];
        $response = $this->client->get(self::API_URL);
        $result = json_decode((string)$response->getBody());
        foreach ($result->results as $each){
        if ($each->episode == $searchedEpisode){
            $eps []= [
                'id'=> $each->id,
                'name'=>$each->name,
                'episode'=>$each->episode,
                'air_date'=>$each->air_date
            ];
        }
    }
        return $eps;
    }
}