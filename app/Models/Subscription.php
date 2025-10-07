<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Subscription extends Model
{
use HasFactory;
protected $fillable = ['user_id','plan_name','status','starts_at','ends_at','stripe_subscription_id'];
protected $casts = ['starts_at'=>'datetime','ends_at'=>'datetime'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isActive()
    {
        return $this->status === 'active';
    }
}
