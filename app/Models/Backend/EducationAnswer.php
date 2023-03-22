<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class EducationAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'answer',
        'right_answer',
        'comment',
        'by_user',
        'date_answered',
        'date_commented'
    ];

    public $timestamps = false;

    /** 
     * Education Question Relation
     * @return BelongsTo
     */
    public function question() {
        return $this->belongsTo(EducationQuestion::class, 'question_id');
    }

    /** 
     * User Relation
     * @return BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\Models\Access\User\User', 'user_id');
    }
}
