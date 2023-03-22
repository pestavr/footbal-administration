<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class phases extends Model
{
    protected $table='phases';
    protected $fillable=array('title', 'created_at', 'updated_at');
    protected $primaryKey= 'id';
}
