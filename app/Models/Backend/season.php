<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class season extends Model
{
    protected $table='season';
    protected $fillable=array('season_id','period', 'enarxi', 'lixi', 'running');
    protected $primaryKey= 'season_id';

    public static function getRunning(){
    	return season::select('season_id')->where('running','=',1)->first();
    }
    public static function getName(){
    	return season::select('period')->where('running','=',1)->first();
    }
    public static function getEnarxi(){
    	return season::select('enarxi')->where('running','=',1)->first();
    }
    public static function getLixi(){
    	return season::select('lixi')->where('running','=',1)->first();
    }

    public static function getAll($id){
        return season::select('period','enarxi','lixi')->where('season_id','=',$id)->first();
    }
}
