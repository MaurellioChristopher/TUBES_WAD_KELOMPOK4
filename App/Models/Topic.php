<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory; // Mengaktifkan factory untuk kebutuhan testing dan seeding

    // Menentukan kolom yang boleh diisi secara mass assignment
    protected $fillable = [
        'title',        // Judul topik
        'description',  // Deskripsi topik
    ];

    // Relasi: satu topik dapat memiliki banyak postingan
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Relasi: satu topik dapat memiliki banyak learning goals
    public function learningGoals()
    {
        return $this->hasMany(LearningGoal::class);
    }
}
