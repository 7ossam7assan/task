<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([

            'name'      => 'admin',
            'email'     => 'admin@admins.com',
            'password'  => bcrypt('123456789'),
            'type'      => \App\Enums\UserTypeEnum::ADMIN,
            'phone'     => '01143145901',
            'photo'     => 'default.jpg',
        ]);
        DB::table('users')->insert([

            'name'      => 'advertiser',
            'email'     => 'advertiser@advertisers.com',
            'password'  => bcrypt('123456789'),
            'type'      => \App\Enums\UserTypeEnum::ADVERTISER,
            'phone'     => '01069085994',
            'photo'     => 'default.jpg',
        ]);
    }
}
