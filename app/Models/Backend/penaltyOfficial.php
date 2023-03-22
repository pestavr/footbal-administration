<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class penaltyOfficial extends Model
{
     protected $table='penalties_officials';
    protected $fillable=array('id', 'team_id',  'match_id', 'title', 'name', 'infliction_date', 'reason', 'decision_num','fine', 'match_days', 'kind_of_days',  'description', 'efesi', 'remain', 'created_at', 'updated_at');
    protected $primaryKey= 'id';
}