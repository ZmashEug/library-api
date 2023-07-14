<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('book_genre', function (Blueprint $table) {
            $table->foreignId('book_id')->constrained();
            $table->foreignId('genre_id')->constrained();
            $table->primary(['book_id', 'genre_id']);
        });

        Schema::create('author_book', function (Blueprint $table) {
            $table->foreignId('author_id')->constrained();
            $table->foreignId('book_id')->constrained();
            $table->primary(['author_id', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
        Schema::dropIfExists('book_genre');
        Schema::dropIfExists('author_book');
    }
};
