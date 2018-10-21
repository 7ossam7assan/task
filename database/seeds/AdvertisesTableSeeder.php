<?php

use Illuminate\Database\Seeder;

class AdvertisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('advertises')->insert([

            'title'         => 'adv1',
            'content'       => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                               Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                               when an unknown printer took a galley of type and scrambled it to make a type
                               specimen book. It has survived not only five centuries,
                               but also the leap into electronic typesetting, remaining essentially unchanged.
                               It was popularised in the 1960s 
                               with the release of Letraset sheets containing Lorem Ipsum passages,
                               and more recently with desktop publishing 
                               software like Aldus PageMaker including versions of Lorem Ipsum',


            'rate'          => 4,
            'photo'         => 'defaultAdvertise.jpg',
            'price'         => 100,
            'user_id'       => 2,
            'is_active'     => \App\Enums\AdvertiseActiveEnum::ACTIVE,
        ]);
        DB::table('advertises')->insert([
            'title'         => 'adv2',
            'content'       => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                               Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                               when an unknown printer took a galley of type and scrambled it to make a type
                               specimen book. It has survived not only five centuries,
                               but also the leap into electronic typesetting, remaining essentially unchanged.
                               It was popularised in the 1960s 
                               with the release of Letraset sheets containing Lorem Ipsum passages,
                               and more recently with desktop publishing 
                               software like Aldus PageMaker including versions of Lorem Ipsum',


            'rate'          => 3,
            'photo'         => 'defaultAdvertise.jpg',
            'price'         => 150,
            'user_id'       => 2,
            'is_active'     => \App\Enums\AdvertiseActiveEnum::ACTIVE,
        ]);
    }
}
