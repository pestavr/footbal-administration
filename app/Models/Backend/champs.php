<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class champs extends Model
{
    protected $table='champs';
    protected $fillable=array('category', 'logo', 'over', 'ref', 'hel', 'ref_daily', 'hel_daily','eu_Km', 'dia', 'wa_ma', 'wa_ref', 'doc', 'flexible', 'active', 'created_at', 'updated_at');
    protected $primaryKey= 'champ_id';

    public static function getAll($id){
    	return champs::find($id)->first();
    }
}
