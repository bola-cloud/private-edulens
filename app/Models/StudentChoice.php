<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentChoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'choice_id',
        'is_true',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'choice_id', 'id');
    }
}
