<?php

namespace App\Controllers;

use App\Models\Article;
use Twig\Environment;

class ArticleController
{
    private $articles;

    public function __construct()
    {
        $this->articles = [
            new Article("First", "First Description"),
            new Article("Second", "Second Description"),
            new Article("Third", "Third Description"),
        ];
    }
    public function index(Environment $twig)
    {
        return $twig->render('home.twig', ['articles' => $this->articles]);
    }
    public function show(Environment $twig, $articleIndex)
    {
        $article = $this->articles[$articleIndex - 1];
        return $twig->render('article-show.twig', ['article' => $article]);
    }
}