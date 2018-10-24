<?php
use App\User;
use App\Tweets;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Point::class, function (Faker\Generator $faker){
	
	return [
    'team'   => $faker->randomElements($array = array ('bl','tl','or', 'pl'), $count = 1),
		'points' => $faker->numberBetween(500, 5000),
		'audit'  => $faker->randomDigitNotNull,
    'source' => $faker->randomElements($array = array ('points','app','arcade'), $count = 1),
	];
});

$factory->define(App\Tweets::class, function (Faker\Generator $faker){

  return[
    'tweet_id' => $faker->regexify('/^\d{18}$/'),
    'tweet-text' => $faker->realText($maxNbChars = 200, $indexSize = 2),
    'geo_lat' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
    'geo_long' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
    'user_id' => $faker->regexify('/^\d{8}$/'),
    'screen_name' => $faker->userName,
    'name' => $faker->name,
    'profile_image_url' => $faker->imageUrl,
    'is_rt' => 0,
    'deleted_at' => NULL,
    'created_at' => $faker->dateTime('now'),
    'updated_at' => NULL,
  ];
});
