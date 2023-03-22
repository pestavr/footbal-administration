<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class RefereeNotification extends Model
{
    protected $fillable = [
        'match_id',
        'referee_id',
        'notified',
        'accepted',
    ];

}
