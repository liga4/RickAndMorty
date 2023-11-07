<?php

namespace App\Controllers;

use App\Api;
use App\Response;

class SearchController
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function index()
    {
        $episode = $_POST['episode'] ?? null;

        if (is_string($episode) && !empty($episode)) {
            $searchEpisode = $this->api->fetchEpisodeForSearch($episode);
        } else {
            $searchEpisode = null;
        }
        return new Response('episodes/index', [
            'searchEpisode' => $searchEpisode
        ]);
    }
}