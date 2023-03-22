<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class eps extends Model
{
     protected $table='eps_conf';
    protected $fillable=array('eps_id', 'name', 'short_name', 'acronym','etos_idrisis', 'site_address', 'email', 'address', 'tk', 'district', 'city', 'county','region', 'tel','tel2','fax','logo','date_created','date_updated', 'expire_date', 'facebook','twitter', 'active','created_at','updated_at');
    protected $primaryKey= 'eps_id';


    public static function getAll(){
    	return eps::select('eps_id','name', 'short_name', 'acronym', 'etos_idrisis', 'site_address', 'email', 'address','tk', 'district', 'city', 'county','region', 'tel','tel2','fax','logo','date_created','date_updated', 'expire_date', 'facebook','twitter' )->where('active','=',1)->first();
    }
    public static function getAcronym(){
    	return eps::select('acronym')->where('active','=',1)->first();
    }
    public static function getshortName(){
    	return eps::select('short_name')->where('active','=',1)->first();
    }
}