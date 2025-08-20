<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{
    use HasFactory;

    protected $table = 'recharge';
    protected $primaryKey = "id";

    protected $fillable = [
        'user_id',
        'operator',
        'contact_number',
        'recharge_amount',
        'payment_status',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
