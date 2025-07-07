<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Reservation extends Model
{
    //

    use HasUuid;

    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'user_id',
        'event_id',
        'unique_code',
        'is_checked_in'
    ];

    protected $casts = [
        'is_checked_in' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
