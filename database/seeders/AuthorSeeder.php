<?php

namespace database\seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Book;
use Illuminate\Support\Facades\Hash;

class AuthorSeeder extends Seeder
{
    public function run()
    {

        $book1 = Book::create([
            'title' => '1984',
            'description' => 'A novel known for its dystopian depiction of a totalitarian society where the government controls every aspect of citizens lives.',
        ]);

        $book2 = Book::create([
            'title' => 'The Great Gatsby',
            'description' => 'A story of tragic love and the American dream set in the 1920s.',
        ]);

        $book3 = Book::create([
            'title' => 'Harry Potter and the Philosophers Stone',
            'description' => 'The first book in the series about the boy wizard Harry Potter and his adventures at Hogwarts.',
        ]);

        $book4 = Book::create([
            'title' => 'To Kill a Mockingbird',
            'description' => 'A celebrated novel that tells the story of a lawyer defending a black man accused of raping a white woman in 1930s Alabama.',
        ]);

        // Создание пользователей
        $author1 = Author::create([
            'name' => 'George Orwell',
        ]);

        $author2 = Author::create([
            'name' => 'F. Scott Fitzgerald',
        ]);
        
        $author3 = Author::create([
            'name' => 'J.K. Rowling',
        ]);

        $author4 = Author::create([
            'name' => 'Harper Lee',
        ]);

        // Создание ролей
        $genre1 = Genre::create([
            'name' => 'Dystopia',
        ]);

        $genre2 = Genre::create([
            'name' => 'Novel',
        ]);

        $genre3 = Genre::create([
            'name' => 'Fantasy',
        ]);

        $genre4 = Genre::create([
            'name' => 'Classic Literature',
        ]);

        $book1->genres()->attach([$genre1->id]);
        $book1->authors()->attach([$author1->id]);

        $book2->genres()->attach([$genre2->id]);
        $book2->authors()->attach([$author2->id]);

        $book3->genres()->attach([$genre3->id]);
        $book3->authors()->attach([$author3->id]);

        $book4->genres()->attach([$genre4->id]);
        $book4->authors()->attach([$author4->id]);
    }
}