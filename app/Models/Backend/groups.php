<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class groups extends Model
{
     protected $table='group1';
    protected $fillable=array('aa_period', 'omilos', 'category', 'omades', 'title', 'age_level', 'kind','logo',  'qualify','relegation', 'q_mparaz', 'r_mparaz','regular_season', 'created_at','updated_at');
    protected $primaryKey= 'aa_group';


    public static function getTitle($id){
    	return season::select('title')->where('aa_group','=',$id)->first();
    }
}
