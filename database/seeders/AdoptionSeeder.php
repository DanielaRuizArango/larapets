<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Adoption;
use App\Models\Pet;

class AdoptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Adoption::updateOrCreate(
            ['user_id' => 2, 'pet_id' => 2],
            []
        );

        Adoption::updateOrCreate(
            ['user_id' => 2, 'pet_id' => 1],
            []
        );

        foreach ([1, 2] as $petId) {
            $pet = Pet::find($petId);
            if ($pet) {
                $pet->adopted = 1;
                $pet->save();
            }
        }
    }
}
