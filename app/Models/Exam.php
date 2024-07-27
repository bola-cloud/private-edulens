<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'time',
        'degree',
        'compulsory',
        'success_degree',
        'section_id',
    ];
    protected $casts = [
        'compulsory' => 'boolean',
    ];
    
    public function section()
    {
        return $this->belongsTo(Section::class,'section_id');
    }
    public function questions()
    {
        return $this->hasMany(Question::class,'exam_id');
    }
    public function user()
    {
        return $this->belongsToMany(User::class,'student_exams','exam_id','user_id');
    }
}
