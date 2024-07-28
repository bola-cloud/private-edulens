<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExam extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'exam_id',
        'student_degree',
        'exam_degree'
    ];
    public function choice()
    {
        return $this->hasMany(Choice::class);
    }
}
