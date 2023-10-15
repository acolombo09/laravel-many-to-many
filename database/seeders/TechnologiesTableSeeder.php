<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // stesso procedimento usato per types ma come scritto a lezione
        $technologies = ['JavaScript', 'Vue', 'PHP', 'Laravel', 'React', 'TypeScript', 'CSS', 'SCSS', 'Bootstrap', 'Tailwind', 'NodeJs', 'HTML'];

        foreach ($technologies as $technology) {

            Technology::create([
                'name' => $technology,
            ]);

        }

    }
}
