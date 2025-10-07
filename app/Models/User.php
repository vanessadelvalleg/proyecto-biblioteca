<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable

{
use HasApiTokens, Notifiable, HasFactory;
protected $fillable = ['name','email','password'];
protected $hidden = ['password','remember_token'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }


    public function loans()
    {
        return $this->hasMany(Loan::class);
    }


            public function activeLoansCount()
            {
                return $this->loans()->whereNull('returned_at')->count();
            }

            public function activeSubscription()
        {
            return $this->subscriptions()->where('status', 'active')->first();
        }





}