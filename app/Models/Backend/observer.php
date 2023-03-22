<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class observer extends Model
{
    protected $table='paratirites';
    protected $fillable=array('wa_id', 'waLastName', 'waFirstName', 'waTel', 'waTel2', 'Fname', 'email','memo', 'active','Address','tk','city','created_at', 'updated_at');
    protected $primaryKey= 'wa_id';
}
