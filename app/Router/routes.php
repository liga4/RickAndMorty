<?php

return [
    ['GET', '/', ['App\Controllers\EpisodeController', 'options']],
    ['GET', '/episodes', ['App\Controllers\EpisodeController', 'index']],
    ['GET', '/seasons', ['App\Controllers\SeasonController', 'index']],
    ['GET', '/season/{id}', ['App\Controllers\SeasonController', 'show']],
    ['GET', '/episode/{id}', ['App\Controllers\EpisodeController', 'show']],
    ['GET', '/search', ['App\Controllers\EpisodeController', 'search']]

];