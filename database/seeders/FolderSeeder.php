<?php

namespace Database\Seeders;

use App\Models\Folder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cấp 1
        for ($i = 1; $i <= 3; $i++) {
            $parent1 = Folder::create(['name' => "Folder Level 1 - $i"]);

            // Cấp 2
            for ($j = 1; $j <= 2; $j++) {
                $parent2 = Folder::create([
                    'name' => "Folder Level 2 - $i.$j",
                    'parent_id' => $parent1->id
                ]);

                // Cấp 3
                for ($k = 1; $k <= 2; $k++) {
                    $parent3 = Folder::create([
                        'name' => "Folder Level 3 - $i.$j.$k",
                        'parent_id' => $parent2->id
                    ]);

                    // Cấp 4
                    for ($l = 1; $l <= 2; $l++) {
                        Folder::create([
                            'name' => "Folder Level 4 - $i.$j.$k.$l",
                            'parent_id' => $parent3->id
                        ]);
                    }
                }
            }
        }
    }
}
