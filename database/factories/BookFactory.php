<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'title' => $this->faker->sentence(),
          'description' => $this->faker->paragraph(),
          'author_id' => rand(1,2),
          'language' => 'English',
          'status' => 1,
          'thumbnail' => "https://picsum.photos/300/300?random=".Str::random(10)
        ];
    }
}
