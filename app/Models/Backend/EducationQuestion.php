<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class EducationQuestion extends Model
{
    protected $fillable = [
        'referee_education_id',
        'question',
        'answer',
        'suggestion',
        'date_added'
    ];

    public $timestamps = false;

    /** 
     * Referee Education Relation
     * @return BelongsTo
     */
    public function education() {
        return $this->belongsTo(RefereeEducation::class, 'referee_education_id');
    }

    /** 
     * Answerds Relation
     * @return HasMany
     */
    public function answers() {
        return $this->hasMany(EducationAnswer::class, 'question_id');
    }


}
