<?php

namespace App\Controllers;

use App\Api;
use App\Response;

class EpisodeController
{

    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function options(): Response
    {

        $episodes = $this->api->fetchEpisodes();
        $seasons = $this->api->fetchSeasons();
        return new Response('episodes/options',
            [
                'episodes' => $episodes,
                'seasons' => $seasons
            ]);
    }

    public function index(): Response
    {
        $episodes = $this->api->fetchEpisodes();
        return new Response ('episodes/index',
            [
                'episodes' => $episodes,
            ]);
    }

    public function show(array $vars): Response
    {
        $id = (int)$vars['id'];
        $episode = $this->api->fetchEpisode($id);
        $characters = [];
        $char = $episode->getCharacters();
        foreach ($char as $character) {
            $data = json_decode(file_get_contents($character));
            $characters [] = ['name' => $data->name, 'image' => $data->image];
        }
        return new Response(
            'episodes/show',
            [
                'episode' => $episode,
                'characters' => $characters
            ]
        );
    }
}