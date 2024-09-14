<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    $title = $faker->name;
    return [
      'category_id'=>$faker->randomDigit,
      'author_id'=>$faker->randomDigit,
      'title' => $title,
      'slug' => Str::slug($title, '-'),
      'availability'=> $faker->randomElement(['yes', 'no']),
      'price'=> $faker->numberBetween($min = 500, $max = 5000),
      'rating'=> $faker->randomFloat($nbMaxDecimals = 1, $min = 0, $max = 5),
      'publisher'=> $faker->name,
      'country_of_publisher'=> $faker->country,
      'isbn' => $faker->numberBetween(1000000000, 9999999999),
     'isbn_10' => $faker->numberBetween(1000000000, 9999999999),
      'audience' =>$faker->numberBetween($min = 500, $max = 1000),
      'format'=> $faker->randomElement(['think chapters', 'page numbers','paragraph spacing']),
      'language'=> $faker->locale,
      'total_pages'=> $faker->numberBetween($min = 50, $max = 100),
      'downloaded'=> $faker->numberBetween($min = 5000, $max = 5000000),
      'edition_number'=> $faker->randomElement(['3', '4','5','2','1','6']),
      'recommended'=> $faker->randomElement(['yes', 'no']),
      'description'=> $faker->text($maxNbChars = 300),
      'book_img'=> 'No image found',
      'book_upload' => $faker->randomElement(['PDF', 'PRC', 'PDB']),
      'status'=> $faker->randomElement(['ACTIVE', 'DEACTIVE','UPCOMING'])
    ];
});
