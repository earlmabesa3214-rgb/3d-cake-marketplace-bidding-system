<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BakerApplication extends Model
{
    protected $fillable = [
        'first_name','last_name','email','phone','password',
        'shop_name','experience_years','min_order_price','social_media','bio','specialties',
        'seller_type','full_address','address','latitude','longitude',
        'dti_sec_number','business_permit','dti_certificate','sanitary_permit','bir_certificate',
        'gov_id_type','gov_id_front','gov_id_back','id_selfie','food_safety_cert',
        'portfolio','status','rejection_reason','reviewed_at',
    ];
    protected $casts = [
        'specialties' => 'array',
        'portfolio'   => 'array',
        'reviewed_at' => 'datetime',
    ];
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}