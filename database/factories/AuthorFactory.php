<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Author;
use Faker\Generator as Faker;

$factory->define(Author::class, function (Faker $faker) {
    $title = $faker->name;
    return [
      'title' => $title,
      'slug' => Str::slug($title, '-'),
      'designation' => $faker->jobTitle, 
      'dob' => $faker->date($format = 'd-m-Y', $max = 'now'),
      'country' => $faker->country,
      'email' => $faker->email,
      'phone' => $faker->numberBetween(1000000000, 9999999999),
      'description' => $faker->text($maxNbChars = 400),
      'author_feature' => $faker->randomElement(['yes', 'no']),
      'facebook_id' => $faker->safeEmail,
      'twitter_id' => $faker->safeEmail,
      'youtube_id' => $faker->freeEmail,
      'pinterest_id' => $faker->freeEmail,
      'author_img' => 'No image found',
      'status' => $faker->randomElement(['ACTIVE', 'DEACTIVE'])
    ];
});
