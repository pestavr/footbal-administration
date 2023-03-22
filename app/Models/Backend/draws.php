<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class draws extends Model
{
    protected $table='draws';
    protected $fillable=array('group', 'team', 'key', 'created_at', 'updated_at');
    protected $primaryKey= 'id';
}