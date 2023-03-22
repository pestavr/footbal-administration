<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class exodologia extends Model
{
    protected $table='exodologia';
    protected $fillable=array('id','match_id', 'ref_sal', 'ref_mov', 'hel_sal', 'hel_mov', 'ref_daily', 'hel_daily',  'toll', 'ref_wa_sal', 'ref_wa_mov', 'obs_sal', 'obs_mov', 'doc_sal', 'doc_mov', 'sum', 'penalties', 'comments', 'printable', 'ref_printed');
    protected $primaryKey= 'id';
}
