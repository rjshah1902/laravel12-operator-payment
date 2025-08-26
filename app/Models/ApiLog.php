<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    use HasFactory;

    protected $table = 'api_log'; 
    protected $primaryKey = 'id'; 

    protected $fillable = [
        'user_id',
        'recharge_id',
        'api_for',
        'request_body',
        'response_body',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recharge()
    {
        return $this->belongsTo(Recharge::class, 'recharge_id');
    }
}
