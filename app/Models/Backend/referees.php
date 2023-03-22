<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class referees extends Model
{
    protected $table='referees';
    protected $fillable=array('Lastname', 'smsLastName', 'Firstname', 'Geniki', 'Fname', 'Bdate', 'address','city', 'tk', 'tel', 'smstel', 'email', 'active', 'startpoint', 'created_at', 'updated_at');
    protected $primaryKey= 'refaa';
}
