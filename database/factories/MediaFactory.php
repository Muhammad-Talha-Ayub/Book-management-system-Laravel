<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Media;
use Faker\Generator as Faker;

$factory->define(Media::class, function (Faker $faker) {
    $title = $faker -> name;
    return [
       'title'=> $title,
       'slug' => Str::slug($title, '-'),
       'media_type' =>$faker->randomElement(['gallery','slider']) ,
       'media_img'=> 'No Image Found',
       'description'=>$faker-> text($maxNbChars = 200),
        'status'=> $faker->randomElement(['ACTIVE', 'DEACTIVE'])
    ];
});
