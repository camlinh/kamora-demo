<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Author::create([
        'name' => 'Ludwig van Beethoven',
        'link' => 'https://en.wikipedia.org/wiki/Ludwig_van_Beethoven'
      ]);

      Author::create([
        'name' => 'Cristiano Ronaldo',
        'link' => 'https://en.wikipedia.org/wiki/Cristiano_Ronaldo'
      ]);
    }
}
