<?php

namespace App\Http\Controllers\Api;

use App\Helper\GeoHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vicopo\Vicopo;

class GeoController extends Controller
{
    public function cities(Request $request)
    {
        $results = GeoHelper::getCitiesFromCountry($request->get('country'));
        ob_start(); ?>
        <label for="citybirth" class="required form-label">
            Ville de Naissance
        </label>
        <select id="citybirth" class="form-select form-select-solid" data-placeholder="Selectionnez une ville de naissance" name="citybirth">
            <option value=""></option>
            <?php foreach ($results as $result) { ?>
            <option value="<?= $result ?>"><?= $result ?></option>
            <?php } ?>
        </select>
        <?php
        return response()->json(ob_get_clean());
    }

    public function citiesByPostal($postal)
    {
        $results = Vicopo::https($postal);
        ob_start(); ?>
        <label for="city" class="required form-label">
            Ville
        </label>
        <select id="city" class="form-select form-select-solid" data-placeholder="Selectionnez une ville" name="city">
            <option value=""></option>
            <?php foreach ($results as $result) { ?>
                <option value="<?= $result->city ?>"><?= $result->city ?></option>
            <?php } ?>
        </select>
        <?php
        return response()->json(ob_get_clean());
    }
}
