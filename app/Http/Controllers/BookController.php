<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('authors', 'genres')->get();

        $formattedBooks = $books->map(function ($book) {
            $authors = $book->authors->pluck('name')->implode(', ');
            $genres = $book->genres->pluck('name')->implode(', ');

            return [
                'title' => $book->title,
                'description' => $book->description,
                'author' => $authors,
                'genre' => $genres,
            ];
        });

        return response()->json($formattedBooks);
    }

    public function show(Request $request)
    {
        $validator = app('validator')->make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $bookId = $request->input('id');

        $book = Book::with('authors', 'genres')->find($bookId);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $authors = $book->authors->pluck('name')->implode(', ');
        $genres = $book->genres->pluck('name')->implode(', ');

        $formattedBook = [
            'title' => $book->title,
            'description' => $book->description,
            'author' => $authors,
            'genre' => $genres,
        ];

        return response()->json($formattedBook);
    }

    public function store(Request $request)
    {
        $validator = app('validator')->make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'title' => 'required',
            'description' => 'required',
            'author' => 'required',
            'genre' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        //return response()->json($role, 201);
        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Only admins can add books'], 403);
        }

        $BookData = $request->only('title', 'description');
        $book = Book::firstOrCreate($BookData);

        $AuthorData = $request->only('author');
        $AuthorData['name'] = $AuthorData['author'];
        unset($AuthorData['author']);
        //return response()->json($AuthorData, 201);
        $author = Author::firstOrCreate($AuthorData);

        $GenreData = $request->only('genre');
        $GenreData['name'] = $GenreData['genre'];
        unset($GenreData['genre']);
        $genre = Genre::firstOrCreate($GenreData);

        $book->genres()->attach($genre->id);
        $book->authors()->attach($author->id);

        return response()->json($book, 201);
    }

    public function destroy(Request $request)
    {
        $validator = app('validator')->make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Only admins can delete books'], 403);
        }
        $bookId = $request->input('id');
        $book = Book::findOrFail($bookId);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->genres()->detach();
        $book->authors()->detach();
        $book->delete();

        return response()->json(['message' => 'Book deleted']);
    }

    public function export(Request $request)
    {
        $validator = app('validator')->make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'title' => 'required',
            'description' => 'required',
            'author' => 'required',
            'genre' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Uploading a list of books in csv format requires the admin role'], 403);
        }
        $books = Book::all();

        $csvHeader = ['Title', 'Description'];
        $csvRows = [];

        foreach ($books as $book) {
            $csvRows[] = [$book->title, $book->description];
        }

        $callback = function () use ($csvHeader, $csvRows) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeader);

            foreach ($csvRows as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=books.csv',
        ];

        return response()->streamDownload($callback, 'books.csv', $headers);
    }
}
