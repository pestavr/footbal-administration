<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class court extends Model
{
    protected $table='fields';
    protected $fillable=array('eps_name', 'sort_name', 'smsName', 'fild', 'apoditiria', 'Sheets', 'address', 'tk','map', 'city','city2','city3','Kms','Kms2','Kms3','diodia','diodia2','diodia3','charge','latitude','longitude','zoom','active', 'tel','fax', 'email', 'administrator', 'tel_admin', 'created_at', 'updated_at');
    protected $primaryKey= 'aa_gipedou';
}

