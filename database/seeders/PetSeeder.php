<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pet;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pet::updateOrCreate(
            ['name' => 'Firulais'],
            [
                'kind' => 'Dog',
                'weight' => '10',
                'age' => '2',
                'breed' => 'Golden Retriever',
                'location' => 'Bogota',
                'description' => 'Friendly dog',
                'adopted' => true,
            ]
        );

        Pet::updateOrCreate(
            ['name' => 'Michi'],
            [
                'kind' => 'Cat',
                'weight' => '5',
                'age' => '1',
                'breed' => 'Siamese',
                'location' => 'Cali',
                'description' => 'Friendly cat',
                'adopted' => true,
            ]
        );

        Pet::updateOrCreate(
            ['name' => 'Benjamin'],
            [
                'kind' => 'Dog',
                'weight' => '18',
                'age' => '9',
                'breed' => 'Beagle',
                'location' => 'Medellin',
                'description' => 'fat',
                'adopted' => true,
            ]
        );

        Pet::updateOrCreate(
            ['name' => 'Coco'],
            [
                'kind' => 'Cat',
                'weight' => '5',
                'age' => '2',
                'breed' => 'Persian',
                'location' => 'Pereira',
                'description' => 'bites',
                'adopted' => true,
            ]
        );

        Pet::updateOrCreate(
            ['name' => 'Milo'],
            [
                'kind' => 'Cat',
                'weight' => '6',
                'age' => '2',
                'breed' => 'Persian',
                'location' => 'Armenia',
                'description' => 'sleepy',
                'adopted' => true,
            ]
        );
    }
}

