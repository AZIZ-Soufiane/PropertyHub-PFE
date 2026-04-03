<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Books Explorer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-full">

    <div class="p-4 pb-20" x-data="booksApp()">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">📚 Books Explorer</h1>
            <button @click="refresh()" 
                    class="px-5 py-2.5 bg-violet-600 hover:bg-violet-700 text-white rounded-2xl text-sm font-medium flex items-center gap-2">
                🔄 Refresh
            </button>
        </div>

        <!-- Search Input -->
        <input 
            type="text" 
            x-model="search"
            @keyup.enter="searchBooks()"
            placeholder="Search books or authors..." 
            class="w-full px-5 py-4 rounded-3xl border border-gray-300 dark:border-gray-600 mb-6 focus:outline-none focus:border-violet-500 bg-white dark:bg-gray-800">

        <!-- Books Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
            <template x-for="book in filteredBooks" :key="book.key">
                <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow border border-gray-100 dark:border-gray-700">
                    <div class="h-52 bg-gray-100 dark:bg-gray-700 flex items-center justify-center p-4">
                        <img 
                            :src="book.coverUrl" 
                            :alt="book.title"
                            class="max-h-full w-auto rounded-lg shadow object-contain"
                            onerror="this.src='https://picsum.photos/id/201/200/300'">
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-base line-clamp-2 mb-1" x-text="book.title"></h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400" x-text="book.author"></p>
                        <p class="text-xs text-gray-400 mt-2" x-text="book.year"></p>
                    </div>
                </div>
            </template>
        </div>

        <!-- Empty State -->
        <div x-show="filteredBooks.length === 0" class="text-center py-20 text-gray-500">
            No books found. Try a different search.
        </div>

    </div>

    <script>
        function booksApp() {
            return {
                books: <?php echo json_encode($books ?? [], 15, 512) ?>,
                search: '',

                get filteredBooks() {
                    if (!this.search.trim()) return this.books;
                    const term = this.search.toLowerCase().trim();
                    return this.books.filter(book => 
                        (book.title && book.title.toLowerCase().includes(term)) ||
                        (book.author && book.author.toLowerCase().includes(term))
                    );
                },

                async searchBooks() {
                    if (!this.search.trim()) return;
                    try {
                        const res = await fetch(`https://openlibrary.org/search.json?q=${encodeURIComponent(this.search)}&limit=30`);
                        if (res.ok) {
                            const data = await res.json();
                            this.books = data.docs.map(book => ({
                                title: book.title || 'Untitled',
                                author: book.author_name ? book.author_name[0] : 'Unknown Author',
                                year: book.first_publish_year ? book.first_publish_year.toString() : '',
                                coverUrl: book.cover_i 
                                    ? `https://covers.openlibrary.org/b/id/${book.cover_i}-M.jpg` 
                                    : null,
                                key: book.key
                            }));
                        }
                    } catch (e) {
                        console.error(e);
                    }
                },

                async refresh() {
                    try {
                        const res = await fetch('https://openlibrary.org/search.json?q=best+seller&limit=30');
                        if (res.ok) {
                            const data = await res.json();
                            this.books = data.docs.map(book => ({
                                title: book.title || 'Untitled',
                                author: book.author_name ? book.author_name[0] : 'Unknown Author',
                                year: book.first_publish_year ? book.first_publish_year.toString() : '',
                                coverUrl: book.cover_i 
                                    ? `https://covers.openlibrary.org/b/id/${book.cover_i}-M.jpg` 
                                    : null,
                                key: book.key
                            }));
                        }
                        this.search = '';
                    } catch (e) {
                        console.error(e);
                    }
                }
            };
        }
    </script>
</body>
</html>
<?php /**PATH C:\GitHub\Lab-PHPNative\app\resources\views/books.blade.php ENDPATH**/ ?>