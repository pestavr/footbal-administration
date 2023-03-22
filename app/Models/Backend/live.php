<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class live extends Model
{
    protected $table='live';
    protected $fillable=array('id', 'match_id', 'kind', 'team', 'min', 'player', 'description','sub','created_at', 'updated_at');
    protected $primaryKey= 'id';


    public static function getAll($id){
        return live::select('id', 'match_id', 'kind', 'team', 'min', 'player', 'description','sub','created_at', 'updated_at')->where('match_id','=',$id)->first();
    }

    public static function isStarted($id){
    	$live=live::select('id')->where('match_id','=',$id)->where('kind','=',1)->get();
    	return ($live->isEmpty())?false:true;
    }

    public static function isBStarted($id){
        $live=live::select('id')->where('match_id','=',$id)->where('kind','=',8)->get();
        return ($live->isEmpty())?false:true;
    }
    public static function isEnded($id){
    	$live=live::select('id')->where('match_id','=',$id)->where('kind','=',5)->get();
    	return ($live->isEmpty())?false:true;
    }
    public static function isAEnded($id){
        $live=live::select('id')->where('match_id','=',$id)->where('kind','=',7)->get();
        return ($live->isEmpty())?false:true;
    }

    public static function computeMin($id){
        if (live::isStarted($id) && !live::isBStarted($id)){
            $live=live::select('updated_at')->where('match_id','=',$id)->where('kind','=',1)->first();
            $min=Carbon::now()->diffInMinutes(Carbon::parse($live->updated_at));
        }else{
            $live=live::select('updated_at')->where('match_id','=',$id)->where('kind','=',8)->first();  
            $min=46+intval(Carbon::now()->diffInMinutes(Carbon::parse($live->updated_at)));       
        }

        return $min;
    }
}
