<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'content',
        'is_active',
        'order',
        'course_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class,'section_id');
    }
    public function exam()
    {
        return $this->hasMany(Exam::class, 'section_id');
    }
}
