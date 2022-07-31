<?php

namespace Database\Seeders;

use App\Models\Cms\CmsCategory;
use Illuminate\Database\Seeder;

class CmsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CmsCategory::query()->create([
            'name' => 'Banque en Ligne',
            'slug' => 'banque-en-ligne',
        ])->create([
            'name' => 'Tarifs',
            'slug' => 'tarifs',
        ])->create([
            'name' => 'Carte Bancaire',
            'slug' => 'carte-bancaire',
        ]);
    }
}
