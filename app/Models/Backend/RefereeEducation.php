<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class RefereeEducation extends Model
{
    protected $fillable = [
        'title',
        'type',
        'details',
        'reference_link',
        'status',
        'date_added',
        'added_by_user'
    ];

    public $timestamps = false;

    /** 
     * Questions Relation
     * @return HasMany
     */
    public function questions() {
        return $this->hasMany(EducationQuestion::class, 'referee_education_id');
    }
}
