<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void {
        $types = [
            'FrontEnd', 
            'Backend', 
            'FullStack', 
            'Design', 
            'DevOps'
        ];

        // come a lezione, creo qua le nuove istanze di type
        // per non rifare tutte le CRUD
        foreach ($types as $type) {

            $newType = new Type();
            $newType->name = $type;
            $newType->color = $faker->rgbColor();

            $newType->save();
        }
    }
}
