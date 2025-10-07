<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Loan extends Model
{
use HasFactory;
protected $fillable = ['user_id','book_id','loaned_at','due_date','returned_at'];
protected $casts = ['loaned_at'=>'datetime','due_date'=>'datetime','returned_at'=>'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    protected static function booted()
{
    static::creating(function ($loan) {
        $user = User::find($loan->user_id);

        $maxLoans = $user->plan_name === 'premium' ? 5 : 2;
        $currentLoans = Loan::where('user_id', $user->id)
                            ->whereNull('returned_at')
                            ->count();

        if ($currentLoans >= $maxLoans) {
            throw new \Exception('Has alcanzado el límite de préstamos permitidos.');
        }
    });
}
}