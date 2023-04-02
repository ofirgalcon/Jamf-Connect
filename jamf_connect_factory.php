<?php

// Database seeder
// Please visit https://github.com/fzaninotto/Faker for more options

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Jamf_connect_model::class, function (Faker\Generator $faker) {

    return [
        'display_name' => $faker->word(),
        'jamf_connect_id' => $faker->word(),
        'password_last_changed' => $faker->word(),
        'first_name' => $faker->word(),
        'last_name' => $faker->word(),
        'locale' => $faker->word(),
        'login' => $faker->word(),
        'time_zone' => $faker->word(),
        'last_analytics_checkin' => $faker->word(),
        'last_sign_in' => $faker->word(),
        'last_license_check' => $faker->word(),
        'password_current' => $faker->boolean(),
    ];
});
