<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function index()
    {
        try {
            $response = Http::timeout(10)->get('https://openlibrary.org/search.json', [
                'q' => 'best seller',
                'limit' => 30,
                'fields' => 'key,title,author_name,first_publish_year,cover_i',
            ]);

            $rawBooks = $response->successful()
                ? ($response->json()['docs'] ?? [])
                : [];
        } catch (\Exception $e) {
            $rawBooks = [];
        }

        $books = collect($rawBooks)->map(function ($book) {
            return [
                'key'      => $book['key'] ?? uniqid(),
                'title'    => $book['title'] ?? 'Unknown Title',
                'author'   => isset($book['author_name']) ? $book['author_name'][0] : 'Unknown Author',
                'year'     => $book['first_publish_year'] ?? '',
                'coverUrl' => isset($book['cover_i'])
                    ? "https://covers.openlibrary.org/b/id/{$book['cover_i']}-M.jpg"
                    : null,
            ];
        })->values()->all();

        return view('books', compact('books'));
    }
}
