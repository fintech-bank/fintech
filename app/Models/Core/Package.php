<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\Package
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $type_prlv
 * @property int $visa_classic
 * @property int $check_deposit
 * @property int $payment_withdraw
 * @property int $overdraft
 * @property int $cash_deposit
 * @property int $withdraw_international
 * @property int $payment_international
 * @property int $payment_insurance
 * @property int $check
 * @property int $nb_carte_physique
 * @property int $nb_carte_virtuel
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCashDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCheckDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereNbCartePhysique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereNbCarteVirtuel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereOverdraft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePaymentInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePaymentInternational($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePaymentWithdraw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereTypePrlv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereVisaClassic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereWithdrawInternational($value)
 * @mixin \Eloquent
 * @mixin IdeHelperPackage
 * @property string $type_cpt
 * @property int $subaccount
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereSubaccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereTypeCpt($value)
 */
class Package extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function getTypePrlvAttribute($value)
    {
        switch ($value) {
            case 'mensual': return 'Mensuel';
                break;
            case 'trim': return 'Trimestriel';
                break;
            case 'sem': return 'Semestriel';
                break;
            default: return 'Annuel';
                break;
        }
    }
}
