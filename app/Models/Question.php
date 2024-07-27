<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'image',
        'exam_id',
        'is_active',
    ];
    public function exam()
    {
        return $this->belongsTo(Exam::class,'exam_id');
    }
    public function choice()
    {
        return $this->hasMany(Choice::class,'question_id');
    }
}
