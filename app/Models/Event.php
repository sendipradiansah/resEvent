<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Event extends Model
{
    use HasUuid;

    public $incrementing = false;
    protected $keyType = 'string';


    //
    protected $fillable = [
        'name',
        'description',
        'schedule',
        'max_quota'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
