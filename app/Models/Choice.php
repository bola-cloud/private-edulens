<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_id',
        'image',
        'choice',
        'is_correct',
    ];
    public function question()
    {
        return $this->belongsTo(Question::class,'question_id');
    }
    public function user()
    {
        return $this->belongsToMany(User::class,'student_choices','choice_id','user_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'student_choices')
            ->withPivot('is_true')
            ->withTimestamps();
    }
}
