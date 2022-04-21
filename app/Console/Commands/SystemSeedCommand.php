<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SystemSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed System';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Seeding: Liste des agences");
        $this->call("db:seed", ["class" => "AgencySeeder"]);

        $this->info("Seeding: Liste des Plan d'épargne");
        $this->call("db:seed", ["class" => "EpargnePlanSeeder"]);

        $this->info("Seeding: Liste des Plan de Pret");
        $this->call("db:seed", ["class" => "LoanPlanSeeder"]);

        $this->info("Seeding: Liste des Interets des plan de pret");
        $this->call("db:seed", ["class" => "LoanPlanInterestSeeder"]);

        $this->info("Seeding: Liste des Packages");
        $this->call("db:seed", ["class" => "PackageSeeder"]);

        $this->info("Seeding: Liste des Services");
        $this->call("db:seed", ["class" => "ServiceSeeder"]);

        $this->info("Seeding: Liste des Utilisateur de Test");
        $this->call("db:seed", ["class" => "UserSeeder"]);

        $this->info("Seeding: Liste des Catégories de documents");
        $this->call("db:seed", ["class" => "DocumentCategorySeeder"]);

        $this->info("Seeding: Liste des Catégories de pages");
        $this->call("db:seed", ["class" => "CmsCategorySeeder"]);

        $this->info("Seeding: Liste des Sous Catégories de pages");
        $this->call("db:seed", ["class" => "CmsSubCategorySeeder"]);
        return 0;
    }
}
