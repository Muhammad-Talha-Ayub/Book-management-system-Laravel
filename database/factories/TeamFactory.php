<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Team;
use Faker\Generator as Faker;

$factory->define(Team::class, function (Faker $faker) {
    return [
        'fullname'=>$faker->name,
        'designation' => $faker->jobTitle,
        'telephone' => $faker->tollFreePhoneNumber,
        'mobile'=> $faker->phoneNumber,
        'email' => $faker->email,
        'facebook_id' => $faker->safeEmail,
        'twitter_id' => $faker->safeEmail,
        'pinterest_id' => $faker->freeEmail,     
        'profile'=>$faker->text($maxNbChars = 200),
        'team_img'=>'No Image Found',
        'status'=> $faker->randomElement(['ACTIVE', 'DEACTIVE'])
    ];
});
