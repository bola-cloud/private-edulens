<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'content',
        'price',
        'image',
        'category_id',
        'is_active',
        'type',
        'order'
    ];

    public function category()
    {
        return $this->belongsTo(CourseCategory::class,'category_id');
    }

    public function section()
    {
        return $this->hasMany(Section::class,'course_id');
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'student_courses');
    }
}
