<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    public function getBooks(): array
    {
        try {
            $response = Http::timeout(10)->get('https://openlibrary.org/search.json', [
                'q' => 'best seller',
                'limit' => 40,
                'fields' => 'key,title,author_name,first_publish_year,cover_i',
            ]);

            $rawBooks = $response->successful()
                ? ($response->json()['docs'] ?? [])
                : [];
        } catch (\Exception $e) {
            $rawBooks = [];
        }

        return $this->formatBooks($rawBooks);
    }

    public function searchBooks(string $query): array
    {
        try {
            $response = Http::timeout(10)->get('https://openlibrary.org/search.json', [
                'q' => $query,
                'limit' => 40,
                'fields' => 'key,title,author_name,first_publish_year,cover_i',
            ]);

            $rawBooks = $response->successful()
                ? ($response->json()['docs'] ?? [])
                : [];
        } catch (\Exception $e) {
            $rawBooks = [];
        }

        return $this->formatBooks($rawBooks);
    }

    private function formatBooks(array $rawBooks): array
    {
        $formatted = collect($rawBooks)->map(function ($book) {
            return [
                'key' => $book['key'] ?? uniqid(),
                'title' => $book['title'] ?? 'Unknown Title',
                'author' => isset($book['author_name']) ? $book['author_name'][0] : 'Unknown Author',
                'year' => $book['first_publish_year'] ?? '',
                'coverUrl' => isset($book['cover_i'])
                    ? "https://covers.openlibrary.org/b/id/{$book['cover_i']}-M.jpg"
                    : null,
            ];
        })->values()->all();

        // If no books found, return default books
        if (empty($formatted)) {
            return $this->getDefaultBooks();
        }

        return $formatted;
    }

    private function getDefaultBooks(): array
    {
        return [
            [
                'key' => 'default_1',
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'year' => '1960',
                'coverUrl' => 'https://covers.openlibrary.org/b/id/8238486-M.jpg',
            ],
            [
                'key' => 'default_2',
                'title' => '1984',
                'author' => 'George Orwell',
                'year' => '1949',
                'coverUrl' => 'https://covers.openlibrary.org/b/id/8235644-M.jpg',
            ],
            [
                'key' => 'default_3',
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'year' => '1813',
                'coverUrl' => 'https://covers.openlibrary.org/b/id/8235897-M.jpg',
            ],
            [
                'key' => 'default_4',
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'year' => '1925',
                'coverUrl' => 'https://covers.openlibrary.org/b/id/8245010-M.jpg',
            ],
            [
                'key' => 'default_5',
                'title' => 'Jane Eyre',
                'author' => 'Charlotte Brontë',
                'year' => '1847',
                'coverUrl' => 'https://covers.openlibrary.org/b/id/8251248-M.jpg',
            ],
            [
                'key' => 'default_6',
                'title' => 'The Catcher in the Rye',
                'author' => 'J.D. Salinger',
                'year' => '1951',
                'coverUrl' => 'https://covers.openlibrary.org/b/id/8241658-M.jpg',
            ],
        ];
    }
}
