<?php

namespace Database\Seeders;

use App\Models\Cms\CmsSubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CmsSubCategory::query()->create([
            'name' => "Comptes & Cartes",
            "slug" => "comptes-cartes",
            "parent" => true,
            "parent_id" => null,
            "cms_category_id" => 1
        ])->create([
            'name' => "Comptes Courants",
            "slug" => "comptes-courant",
            "parent" => false,
            "parent_id" => 1,
            "cms_category_id" => 1
        ])->create([
            'name' => "Cartes Bancaire",
            "slug" => "cartes-bancaires",
            "parent" => false,
            "parent_id" => 1,
            "cms_category_id" => 1
        ]);
    }
}
