<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(AuthorSeeder::class);
        // Добавьте здесь другие сидеры, если есть
    }
}
