<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class age_level extends Model
{
    protected $table='age_level';
    protected $fillable=array('Age_Level_Title', 'Title');
    protected $primaryKey= 'id';
}
