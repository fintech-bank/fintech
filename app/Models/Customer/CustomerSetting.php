<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerSetting
 *
 * @property int $id
 * @property int $notif_sms
 * @property int $notif_app
 * @property int $notif_mail
 * @property int $nb_physical_card
 * @property int $nb_virtual_card
 * @property int $check
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 *
 * @method static \Database\Factories\Customer\CustomerSettingFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNbPhysicalCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNbVirtualCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNotifApp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNotifMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNotifSms($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerSetting
 */
class CustomerSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
