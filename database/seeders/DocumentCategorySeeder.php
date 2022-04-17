<?php

namespace Database\Seeders;

use App\Models\Core\DocumentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentCategory::create(["name" => "Assurance"]);
        DocumentCategory::create(["name" => "Comptes"]);
        DocumentCategory::create(["name" => "Contrats"]);
        DocumentCategory::create(["name" => "Epargnes"]);
        DocumentCategory::create(["name" => "Courriers"]);
    }
}
