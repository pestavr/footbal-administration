<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class doctor extends Model
{
    protected $table='doctors';
    protected $fillable=array('doc_id', 'docLastName', 'docFirstName', 'docTel', 'docTel2', 'Fname', 'email','memo', 'active','Address','tk','city','created_at', 'updated_at');
    protected $primaryKey= 'doc_id';
}
