<?php

// app/Http/Controllers/ArticleController.php
namespace App\Http\Controllers;

use App\Models\Article;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::query()
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->get(['id','title','slug','category','blurb','image','published_at']);

        return Inertia::render('Instansi/Artikel', [
            'articles' => $articles,
        ]);
    }

    public function show(string $slug)
    {
        $article = Article::where('slug', $slug)
            ->whereNotNull('published_at')
            ->firstOrFail();

        return Inertia::render('Instansi/ArtikelShow', [
            'article' => $article,
        ]);
    }
}
