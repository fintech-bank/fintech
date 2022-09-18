<?php

namespace App\Console\Commands;

use App\Helper\UserHelper;
use App\Models\Customer\CustomerWithdrawDab;
use App\Models\Reseller\Reseller;
use App\Models\User;
use App\Services\GooglePlaceApi;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportDabs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:dabs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import la liste des points de retraits';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $api = new GooglePlaceApi();

        $this->importTabac($api);
        $this->newLine();
        $this->importBank($api);
        $this->newLine();
        $this->importSupermarket($api);

        return 0;
    }

    private function importTabac($api)
    {
        $tabacs = $api->call('tabac');
        $faker = Factory::create('fr_FR');


        if (CustomerWithdrawDab::where('type', 'tabac')->count() == 0) {
            for ($t = 0; $t <= count($tabacs)-1; $t++) {
                $this->info("Installation des Tabacs");
                $ti = 0;
                foreach ($tabacs[$t] as $tabac) {
                    $dab = CustomerWithdrawDab::create([
                        'type' => 'tabac',
                        'name' => $tabac['name'],
                        'address' => $api->getAddress($tabac['geometry']['location']['lat'], $tabac['geometry']['location']['lng'], 'address'),
                        'postal' => $api->getAddress($tabac['geometry']['location']['lat'], $tabac['geometry']['location']['lng'], 'postal'),
                        'city' => $api->getAddress($tabac['geometry']['location']['lat'], $tabac['geometry']['location']['lng'], 'city'),
                        'open' => isset($tabac['opening_hours']['open_now']) ? ($tabac['opening_hours']['open_now'] ? 1 : 0) : 0,
                        'latitude' => $tabac['geometry']['location']['lat'],
                        'longitude' => $tabac['geometry']['location']['lng'],
                        'img' => $tabac['icon'],
                        'place_id' => $tabac['place_id']
                    ]);

                    $user = User::create([
                        'name' => $dab->name,
                        'email' => Str::slug($dab->name).random_int(1,500).'@'.$faker->safeEmailDomain,
                        'password' => \Hash::make('password'),
                        'customer' => 0,
                        'reseller' => 1,
                        'identifiant' => UserHelper::generateID(),
                        'agency_id' => 1
                    ]);

                    $reseller = Reseller::create([
                        'limit_outgoing' => 3500,
                        'limit_incoming' => 10000,
                        'user_id' => $user->id,
                        'customer_withdraw_dabs_id' => $dab->id
                    ]);
                    $ti++;
                }
                $this->info("Nombre de TABAC installé: " . $ti);
            }
        } else {
            for ($t = 0; $t <= count($tabacs)-1; $t++) {
                $this->info("Mise à jours des Tabacs");
                $tu = 0;
                foreach ($tabacs[$t] as $tabac) {
                    CustomerWithdrawDab::where('place_id', $tabac['place_id'])->first()->update([
                        'name' => $tabac['name'],
                        'address' => $api->getAddress($tabac['geometry']['location']['lat'], $tabac['geometry']['location']['lng'], 'address'),
                        'postal' => $api->getAddress($tabac['geometry']['location']['lat'], $tabac['geometry']['location']['lng'], 'postal'),
                        'city' => $api->getAddress($tabac['geometry']['location']['lat'], $tabac['geometry']['location']['lng'], 'city'),
                        'open' => isset($tabac['opening_hours']['open_now']) ? ($tabac['opening_hours']['open_now'] ? 1 : 0) : 0,
                        'latitude' => $tabac['geometry']['location']['lat'],
                        'longitude' => $tabac['geometry']['location']['lng'],
                        'img' => $tabac['icon'],
                        'place_id' => $tabac['place_id']
                    ]);
                    $tu++;
                }
                $this->info("Nombre de TABAC mise à jours: " . $tu);
            }
        }
    }

    private function importBank($api)
    {
        $banks = $api->call('banks');
        $faker = Factory::create('fr_FR');

        if (CustomerWithdrawDab::where('type', 'bank')->count() == 0) {
            for ($b = 0; $b <= count($banks)-1; $b++) {
                $this->info("Installation des banques");
                $bi = 0;
                foreach ($banks[$b] as $bank) {
                    $dab = CustomerWithdrawDab::create([
                        'type' => 'bank',
                        'name' => $bank['name'],
                        'address' => $api->getAddress($bank['geometry']['location']['lat'], $bank['geometry']['location']['lng'], 'address'),
                        'postal' => $api->getAddress($bank['geometry']['location']['lat'], $bank['geometry']['location']['lng'], 'postal'),
                        'city' => $api->getAddress($bank['geometry']['location']['lat'], $bank['geometry']['location']['lng'], 'city'),
                        'open' => isset($bank['opening_hours']['open_now']) ? ($bank['opening_hours']['open_now'] ? 1 : 0) : 0,
                        'latitude' => $bank['geometry']['location']['lat'],
                        'longitude' => $bank['geometry']['location']['lng'],
                        'img' => $bank['icon'],
                        'place_id' => $bank['place_id']
                    ]);

                    $user = User::create([
                        'name' => $dab->name,
                        'email' => Str::slug($dab->name).random_int(1,500).'@'.$faker->safeEmailDomain,
                        'password' => \Hash::make('password'),
                        'customer' => 0,
                        'reseller' => 1,
                        'identifiant' => UserHelper::generateID(),
                        'agency_id' => 1
                    ]);

                    $reseller = Reseller::create([
                        'limit_outgoing' => 3500,
                        'limit_incoming' => 10000,
                        'user_id' => $user->id,
                        'customer_withdraw_dabs_id' => $dab->id
                    ]);
                    $bi++;
                }
                $this->info("Nombre de Banque installé: " . $bi);
            }
        } else {
            for ($b = 0; $b <= count($banks)-1; $b++) {
                $this->info("Mise à jours des banques");
                $bu = 0;
                foreach ($banks[$b] as $bank) {
                    CustomerWithdrawDab::where('place_id', $bank['place_id'])->first()->update([
                        'name' => $bank['name'],
                        'address' => $api->getAddress($bank['geometry']['location']['lat'], $bank['geometry']['location']['lng'], 'address'),
                        'postal' => $api->getAddress($bank['geometry']['location']['lat'], $bank['geometry']['location']['lng'], 'postal'),
                        'city' => $api->getAddress($bank['geometry']['location']['lat'], $bank['geometry']['location']['lng'], 'city'),
                        'open' => isset($bank['opening_hours']['open_now']) ? ($bank['opening_hours']['open_now'] ? 1 : 0) : 0,
                        'latitude' => $bank['geometry']['location']['lat'],
                        'longitude' => $bank['geometry']['location']['lng'],
                        'img' => $bank['icon'],
                        'place_id' => $bank['place_id']
                    ]);
                    $bu++;
                }
                $this->info("Nombre de Banque mise à jours: " . $bu);
            }
        }
    }

    private function importSupermarket($api)
    {
        $supermarkets = $api->call('supermarket');
        $faker = Factory::create('fr_FR');

        if (CustomerWithdrawDab::where('type', 'supermarket')->count() == 0) {
            for ($s = 0; $s <= count($supermarkets)-1; $s++) {
                $this->info("Installation des Supermarchés");
                $si = 0;
                foreach ($supermarkets[$s] as $supermarket) {
                    $dab = CustomerWithdrawDab::create([
                        'type' => 'supermarket',
                        'name' => $supermarket['name'],
                        'address' => $api->getAddress($supermarket['geometry']['location']['lat'], $supermarket['geometry']['location']['lng'], 'address'),
                        'postal' => $api->getAddress($supermarket['geometry']['location']['lat'], $supermarket['geometry']['location']['lng'], 'postal'),
                        'city' => $api->getAddress($supermarket['geometry']['location']['lat'], $supermarket['geometry']['location']['lng'], 'city'),
                        'open' => isset($supermarket['opening_hours']['open_now']) ? ($supermarket['opening_hours']['open_now'] ? 1 : 0) : 0,
                        'latitude' => $supermarket['geometry']['location']['lat'],
                        'longitude' => $supermarket['geometry']['location']['lng'],
                        'img' => $supermarket['icon'],
                        'place_id' => $supermarket['place_id']
                    ]);

                    $user = User::create([
                        'name' => $dab->name,
                        'email' => Str::slug($dab->name).random_int(1,500).'@'.$faker->safeEmailDomain,
                        'password' => \Hash::make('password'),
                        'customer' => 0,
                        'reseller' => 1,
                        'identifiant' => UserHelper::generateID(),
                        'agency_id' => 1
                    ]);

                    $reseller = Reseller::create([
                        'limit_outgoing' => 3500,
                        'limit_incoming' => 10000,
                        'user_id' => $user->id,
                        'customer_withdraw_dabs_id' => $dab->id
                    ]);

                    $si++;
                }
                $this->info("Nombre de supermarché installé: " . $si);
            }
        } else {
            for ($s = 0; $s <= count($supermarkets)-1; $s++) {
                $this->info("Mise à jours des Supermarché");
                $su = 0;
                foreach ($supermarkets[$s] as $supermarket) {
                    CustomerWithdrawDab::where('place_id', $supermarket['place_id'])->first()->update([
                        'name' => $supermarket['name'],
                        'address' => $api->getAddress($supermarket['geometry']['location']['lat'], $supermarket['geometry']['location']['lng'], 'address'),
                        'postal' => $api->getAddress($supermarket['geometry']['location']['lat'], $supermarket['geometry']['location']['lng'], 'postal'),
                        'city' => $api->getAddress($supermarket['geometry']['location']['lat'], $supermarket['geometry']['location']['lng'], 'city'),
                        'open' => isset($supermarket['opening_hours']['open_now']) ? ($supermarket['opening_hours']['open_now'] ? 1 : 0) : 0,
                        'latitude' => $supermarket['geometry']['location']['lat'],
                        'longitude' => $supermarket['geometry']['location']['lng'],
                        'img' => $supermarket['icon'],
                        'place_id' => $supermarket['place_id']
                    ]);
                    $su++;
                }
                $this->info("Nombre de Banque mise à jours: " . $su);
            }
        }
    }
}
